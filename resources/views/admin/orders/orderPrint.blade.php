<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</title>
    <link rel="stylesheet" href="{{ asset('/') }}alt/plugins/fontawesome-free/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', Arial, Helvetica, sans-serif; font-size: 13px; color: #1f2937; background: #f1f5f9; }

        @page { size: A4; margin: 12mm; }

        .invoice-box { width: 100%; max-width: 800px; margin: 24px auto; background: #fff; padding: 28px; box-shadow: 0 4px 20px rgba(0,0,0,.08); }

        /* Header */
        .inv-header { display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 3px solid #198754; padding-bottom: 16px; margin-bottom: 18px; }
        .inv-header .company-title { font-size: 22px; font-weight: bold; color: #198754; }
        .inv-header .company-addr { font-size: 12px; color: #6b7280; margin-top: 4px; max-width: 320px; }
        .inv-header .inv-meta { text-align: right; }
        .inv-header .inv-meta .label { font-size: 20px; font-weight: bold; letter-spacing: 2px; color: #198754; }
        .inv-header .inv-meta .row { font-size: 12.5px; margin-top: 4px; color: #374151; }

        /* Bill row */
        .bill-row { display: flex; justify-content: space-between; margin-bottom: 18px; }
        .bill-box { font-size: 12.5px; line-height: 1.6; }
        .bill-box .heading { font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #9ca3af; font-weight: bold; margin-bottom: 4px; }
        .status-badge { display: inline-block; padding: 4px 14px; border-radius: 4px; font-weight: bold; font-size: 12px; letter-spacing: 1px; color: #fff; }

        /* Tables */
        table { width: 100%; border-collapse: collapse; }
        table th, table td { border: 1px solid #cbd5e1; padding: 8px 10px; }
        table thead th { background: #198754 !important; color: #fff !important; font-size: 12px; text-align: left; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }

        tfoot td, .totals td { font-size: 12.5px; }
        .totals .label { text-align: right; font-weight: bold; }
        .totals .grand td { background: #f0fdf4 !important; font-size: 14px; font-weight: bold; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        .totals .paid td { color: #15803d; }
        .totals .due td { color: #b91c1c; font-weight: bold; }

        .section-title { font-size: 12px; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; color: #374151; margin: 22px 0 8px; }

        .inv-footer { text-align: center; margin-top: 28px; font-size: 11.5px; color: #9ca3af; border-top: 1px solid #e5e7eb; padding-top: 12px; }

        .print-bar { text-align: center; margin: 18px 0; }
        .btn-print { background: #198754; color: #fff; border: none; padding: 10px 26px; border-radius: 6px; font-size: 14px; cursor: pointer; }

        /* Avoid breaking rows across pages */
        tr { page-break-inside: avoid; }
        thead { display: table-header-group; }

        @media print {
            body { background: #fff; }
            .invoice-box { box-shadow: none; margin: 0; max-width: 100%; padding: 0; }
            .print-bar { display: none; }
            table th, table td { border: 1px solid #000 !important; }
            table thead th { background: #198754 !important; color: #fff !important; }
        }
    </style>
</head>
<body>
@php
    $shippingCost = (float) ($order->delivery_cost ?? 0);
    $totalWithShipping = (float) ($order->grand_total ?? ($order->subtotal + $shippingCost));
    $areaLabel = $order->delivery_area === 'outside' ? 'Outside Dhaka' : ($order->delivery_area === 'inside' ? 'Inside Dhaka' : null);
    $ps = $order->payment_status;
    $psColor = $ps == 'paid' ? '#15803d' : ($ps == 'unpaid' ? '#b91c1c' : '#d97706');
    $paid = (float) $order->paid();
@endphp

<div class="invoice-box">

    <!-- HEADER -->
    <div class="inv-header">
        <div>
            @if($ws->logo())
                <img src="{{ route('imagecache', ['template' => 'original', 'filename' => $ws->logo_alt()]) }}" height="48" style="margin-bottom:6px;">
            @endif
            <div class="company-title">{{ $ws->website_title }}</div>
            <div class="company-addr">{{ $ws->contact_address }}</div>
        </div>
        <div class="inv-meta">
            <div class="label">INVOICE</div>
            <div class="row"><strong>Invoice #:</strong> {{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</div>
            <div class="row"><strong>Date:</strong> {{ $order->created_at->format('d M Y') }}</div>
        </div>
    </div>

    <!-- BILL TO + STATUS -->
    <div class="bill-row">
        <div class="bill-box">
            <div class="heading">Bill To</div>
            <strong>{{ $order->name ?? optional($order->user)->name }}</strong><br>
            {{ $order->email ?? optional($order->user)->email }}<br>
            {{ $order->mobile ?? optional($order->user)->mobile }}<br>
            @if($order->address_title){{ $order->address_title }}@endif
        </div>
        <div class="bill-box" style="text-align:right;">
            <div class="heading">Payment Status</div>
            <span class="status-badge" style="background: {{ $psColor }};">{{ strtoupper($ps) }}</span>
            @if($areaLabel)
                <div style="margin-top:8px; font-size:12px; color:#6b7280;">Delivery: <strong>{{ $areaLabel }}</strong></div>
            @endif
            <div style="margin-top:4px; font-size:12px; color:#6b7280;">Method: <strong>{{ strtoupper($order->payment_method ?? 'COD') }}</strong></div>
        </div>
    </div>

    <!-- ITEMS -->
    <table>
        <thead>
            <tr>
                <th style="width:48px;">SL</th>
                <th>Product Name</th>
                <th style="width:110px;" class="text-right">Price</th>
                <th style="width:70px;" class="text-center">Qty</th>
                <th style="width:130px;" class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $item->product_name }}</td>
                <td class="text-right">{{ number_format($item->product_price, 2) }}</td>
                <td class="text-center">{{ $item->quantity }}</td>
                <td class="text-right">{{ number_format($item->total_cost, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot class="totals">
            <tr>
                <td colspan="4" class="label">Sub Total</td>
                <td class="text-right">{{ number_format($order->subtotal, 2) }}</td>
            </tr>
            <tr>
                <td colspan="4" class="label">Shipping{{ $areaLabel ? ' (' . $areaLabel . ')' : '' }}</td>
                <td class="text-right">{{ number_format($shippingCost, 2) }}</td>
            </tr>
            <tr class="grand">
                <td colspan="4" class="label">Grand Total</td>
                <td class="text-right">{{ number_format($totalWithShipping, 2) }}</td>
            </tr>
            <tr class="paid">
                <td colspan="4" class="label">Paid</td>
                <td class="text-right">{{ number_format($paid, 2) }}</td>
            </tr>
            <tr class="due">
                <td colspan="4" class="label">Due</td>
                <td class="text-right">{{ number_format(max(0, $totalWithShipping - $paid), 2) }}</td>
            </tr>
        </tfoot>
    </table>

    <!-- TRANSACTIONS -->
    @if($order->payments->count())
        <div class="section-title">Transactions</div>
        <table>
            <thead>
                <tr>
                    <th style="width:48px;">SL</th>
                    <th>Date</th>
                    <th style="width:160px;" class="text-right">Paid Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->payments as $payment)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}</td>
                    <td class="text-right">{{ number_format($payment->paid_amount, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <div class="inv-footer">
        @if($shippingCost > 0 || $order->delivery_area)
            <div style="color:#198754; font-weight:bold; font-size:13px; margin-bottom:4px;">
                <i class="fa fa-truck"></i> Delivery will be within 72 hrs.
            </div>
        @endif
        <div>Thank you for being with us. &middot; Generated on {{ \Carbon\Carbon::now()->format('d M Y h:i A') }}</div>
    </div>

    <div class="print-bar">
        <button class="btn-print" onclick="window.print()"><i class="fa fa-print"></i> Print Invoice</button>
    </div>
</div>
</body>
</html>
