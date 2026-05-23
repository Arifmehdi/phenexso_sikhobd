<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Enrollment;
use App\Models\BookAppointment;
use App\Models\WebsiteParameter;
use App\Models\DeliveryLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Library\SslCommerz\SslCommerzNotification;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmationEmail;

class SslCommerzPaymentController extends Controller
{
    /**
     * Start Appointment Payment Process (Online)
     */
    public function index(Request $request)
    {
        DB::beginTransaction();

        try {

            // Create Appointment (Pending Payment)
            $appointment = BookAppointment::create([
                'name'             => $request->name,
                'email'            => $request->email,
                'mobile'           => $request->mobile,
                'appointment_date' => $request->appointment_date,
                'doctor_id'        => $request->doctor_id,
                'department_id'    => $request->department_id,
                'doctor_fee'       => $request->doctor_fee,
                'message'          => $request->message,
                'chambar_location' => $request->chambar_location ?? '',
                'chamber_schedule' => $request->chamber_schedule ?? '',
                'whatsapp_number'  => $request->whatsapp_number ?? '',
            ]);

            DB::commit();

            // Prepare Payment Data
            $tran_id = $appointment->id . '-' . time();

            $post_data = [
                'total_amount'     => $appointment->doctor_fee,
                'currency'         => config('currency'),
                'tran_id'          => $tran_id,
                'success_url'      => config('success_url'),
                'fail_url'         => config('failed_url'),
                'cancel_url'       => config('cancel_url'),
                'cus_name'         => $appointment->name,
                'cus_email'        => $appointment->email,
                'cus_phone'        => $appointment->mobile,
                'product_name'     => 'Doctor Appointment',
                'shipping_method'  => 'NO',
                'product_category' => 'General',
                'product_profile'  => 'general',
            ];

            $sslc = new SslCommerzNotification();

            return $sslc->makePayment($post_data, 'hosted');

        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()->back()->with(
                'error',
                'Something went wrong: ' . $e->getMessage()
            );
        }
    }

    /**
     * Online Order Store (Hosted Payment)
     */
    public function orderStore(Request $request)
    {
        $ws = WebsiteParameter::first();
        $cartItems = Cart::getCartItems();

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Your cart is empty.');
        }

        $paymentMethod = $request->input('payment_method');

        if ($paymentMethod === 'online') {

            $sslCommerz = new SslCommerzNotification();

            if (!$sslCommerz->areCredentialsSet()) {
                return redirect()->back()->with(
                    'error',
                    'Online payment is currently unavailable. Please choose another payment method.'
                );
            }
        }

        $subtotal = $this->calculateSubtotal($cartItems);

        $deliveryCost = $ws->shipping_charge ?? $request->shipping_price;

        $grandTotal = $subtotal + $deliveryCost;

        DB::beginTransaction();

        try {

            if (Auth::check()) {

                $user = auth()->user();

                if ($request->has('billing_address')) {

                    DeliveryLocation::updateOrCreate(
                        ['user_id' => $user->id],
                        [
                            'address_title' => $request->input('billing_address'),
                            'name'          => $request->input('name'),
                            'email'         => $request->input('email'),
                            'mobile'        => $request->input('mobile'),
                        ]
                    );
                }

                $location = $this->getUserLocation($user);

                if (!$location) {
                    return redirect()->back()->with(
                        'error',
                        'No delivery location found.'
                    );
                }

                $name = $user->name;
                $email = $user->email;
                $mobile = $user->mobile;
                $address = $location->address_title ?? ' ';
                $userId = $user->id;

            } else {

                $request->validate([
                    'name'             => 'required|string|max:255',
                    'email'            => 'nullable|email|max:255',
                    'mobile'           => 'required|string|max:20',
                    'billing_address'  => 'required|string|max:1000',
                ]);

                $name = $request->input('name');
                $email = $request->input('email');
                $mobile = $request->input('mobile');
                $address = $request->input('billing_address');
                $userId = null;
            }

            // 1. Create Order
            $order = Order::create([
                'user_id'         => $userId,
                'name'            => $name,
                'mobile'          => $mobile,
                'email'           => $email,
                'address_title'   => $address,
                'subtotal'        => $subtotal,
                'delivery_cost'   => $deliveryCost,
                'grand_total'     => $grandTotal,
                'payment_method'  => $paymentMethod,
                'payment_status'  => 'unpaid',
                'payment_gateway' => $paymentMethod,
                'order_note'      => $request->order_note,
                'addedby_id'      => $userId,
            ]);

            // 2. Store Order Items
            foreach ($cartItems as $item) {

                OrderItem::create([
                    'order_id'      => $order->id,
                    'user_id'       => $userId,
                    'product_id'    => $item->product_id,
                    'product_name'  => $item->product->name_en,
                    'product_price' => $item->product->final_price,
                    'quantity'      => $item->quantity,
                    'total_cost'    => $item->product->final_price * $item->quantity,
                    'addedby_id'    => $userId,
                ]);
            }

            // 3. Clear Cart
            if ($userId) {

                Cart::where('user_id', $userId)->delete();

            } else {

                Cart::where('session_id', session('session_id'))->delete();
            }

            DB::commit();

            // 4. Handle Payment Redirect
            if ($paymentMethod === 'online') {

                $tran_id = $order->id . '-' . time();

                $post_data = [
                    'total_amount'     => $grandTotal,
                    'currency'         => config('currency'),
                    'tran_id'          => $tran_id,
                    'success_url'      => config('success_url'),
                    'fail_url'         => config('failed_url'),
                    'cancel_url'       => config('cancel_url'),
                    'cus_name'         => $order->name,
                    'cus_email'        => $order->email,
                    'cus_add1'         => $order->address_title,
                    'cus_city'         => 'Dhaka',
                    'cus_postcode'     => '1000',
                    'cus_country'      => 'Bangladesh',
                    'cus_phone'        => $order->mobile,
                    'shipping_method'  => 'NO',
                    'product_name'     => 'Order Payment',
                    'product_category' => 'General',
                    'product_profile'  => 'general',
                ];

                $sslc = new SslCommerzNotification();

                return $sslc->makePayment($post_data, 'hosted');

            } else {

                return redirect()
                    ->route('order.complete')
                    ->with('success', 'Order placed successfully!');
            }

        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()->back()->with(
                'error',
                'Something went wrong: ' . $e->getMessage()
            );
        }
    }

    /**
     * Order & Appointment Payment Success Callback
     */
    public function success(Request $request)
    {
        if (!$request->has('tran_id')) {
            return redirect()->route('user.dashboard')->with(
                'error',
                'Transaction ID not found.'
            );
        }

        $tran_id = $request->tran_id;

        $id = explode('-', $tran_id)[0];

        $order = Order::find($id);

        $appointment = BookAppointment::find($id);

        if ($appointment) {

            if ($appointment->payment_status === 'pending') {
                $appointment->update([
                    'payment_status' => 'paid'
                ]);
            }

            try {

                Payment::create([
                    'order_id'            => $appointment->id,
                    'user_id'             => $appointment->user_id ?? null,
                    'note'                => 'Online Payment Success',
                    'payment_method'      => 'online',
                    'transaction_id'      => $tran_id,
                    'previous_due_amount' => 0.00,
                    'paid_amount'         => $appointment->doctor_fee,
                    'due_amount'          => 0.00,
                    'payment_date'        => now(),
                    'payment_status'      => 'paid',
                    'addedby_id'          => $appointment->user_id ?? null,
                ]);

            } catch (\Exception $e) {

                return redirect('/')->with(
                    'error',
                    'Payment saving failed: ' . $e->getMessage()
                );
            }

            $appointment->update([
                'paid_amount'    => $appointment->doctor_fee,
                'payment_status' => 'paid',
                'order_status'   => 'confirmed',
                'editedby_id'    => $appointment->user_id ?? null,
            ]);

            return redirect('/')->with(
                'success',
                'Appointment payment successful!'
            );
        }

        if ($order) {

            if ($order->payment_status === 'pending') {
                $order->update([
                    'payment_status' => 'paid'
                ]);
            }

            try {

                Payment::create([
                    'order_id'            => $order->id,
                    'user_id'             => $order->user_id,
                    'note'                => 'Online Payment Success',
                    'payment_method'      => 'online',
                    'transaction_id'      => $tran_id,
                    'previous_due_amount' => 0.00,
                    'paid_amount'         => $order->grand_total,
                    'due_amount'          => 0.00,
                    'payment_date'        => now(),
                    'payment_status'      => 'paid',
                    'addedby_id'          => $order->user_id,
                ]);

            } catch (\Exception $e) {

                return redirect('/')->with(
                    'error',
                    'Payment saving failed: ' . $e->getMessage()
                );
            }

            $order->update([
                'paid_amount'    => $order->grand_total,
                'payment_status' => 'paid',
                'editedby_id'    => $order->user_id,
            ]);

            if ($order->email) {

                Mail::to($order->email)
                    ->send(new OrderConfirmationEmail($order));
            }

            foreach ($order->orderItems as $item) {

                if ($item->product && $item->product->type === 'course') {

                    Enrollment::updateOrCreate(
                        [
                            'user_id'    => $order->user_id,
                            'product_id' => $item->product_id
                        ],
                        [
                            'order_id'    => $order->id,
                            'enrolled_at' => now(),
                            'status'      => 'active'
                        ]
                    );
                }
            }

            return redirect()
                ->route('order.complete')
                ->with('success', 'Order payment successful!');
        }

        return redirect('/')->with(
            'error',
            'Order/Appointment not found.'
        );
    }

    public function fail(Request $request)
    {
        BookAppointment::where('transaction_id', $request->tran_id)
            ->update([
                'payment_status' => 'failed'
            ]);

        return view('frontend.home.sslcommerz.fail');
    }

    public function cancel(Request $request)
    {
        return view('frontend.home.sslcommerz.cancel');
    }

    public function ipn(Request $request)
    {
        return response()->json([
            'message' => 'IPN received'
        ]);
    }

    private function getUserLocation($user)
    {
        if ($user) {
            return $user->locations()->first();
        }

        return null;
    }

    private function calculateSubtotal($cartItems)
    {
        return $cartItems->sum(function ($cart) {
            return $cart->product->final_price * $cart->quantity;
        });
    }
}