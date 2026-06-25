<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
    /**
     * Show the "enter your email" form.
     */
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    /**
     * Email the password reset link.
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
        ]);

        // Accept email OR mobile number, trimmed and case-insensitive
        $login = trim($request->input('email'));

        $user = User::whereRaw('LOWER(email) = ?', [strtolower($login)])
            ->orWhere('mobile', $login)
            ->first();

        if (!$user) {
            return back()->withInput($request->only('email'))
                ->withErrors(['email' => 'No account found with that email or mobile number.']);
        }

        if (empty($user->email)) {
            return back()->withInput($request->only('email'))
                ->withErrors(['email' => 'This account has no email on file, so a reset link cannot be sent. Please contact support.']);
        }

        // Always send to the exact stored email
        try {
            $status = Password::sendResetLink(['email' => $user->email]);
        } catch (\Throwable $e) {
            return back()->withInput($request->only('email'))
                ->withErrors(['email' => 'Could not send the reset email right now. Please try again later or contact support.']);
        }

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('success', 'We have emailed your password reset link to ' . $user->email . '. Please check your inbox (and spam folder).');
        }

        return back()->withInput($request->only('email'))
            ->withErrors(['email' => __($status)]);
    }

    /**
     * Show the reset form (opened from the email link).
     */
    public function showResetForm(Request $request, $token)
    {
        return view('auth.passwords.reset', [
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    /**
     * Save the new password.
     */
    public function reset(Request $request)
    {
        $request->validate([
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')
                ->with('success', 'Your password has been reset successfully. Please log in with your new password.');
        }

        return back()->withInput($request->only('email'))
            ->withErrors(['email' => __($status)]);
    }
}
