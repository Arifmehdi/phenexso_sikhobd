<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chalan #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</title>
    <link rel="stylesheet" href="{{ asset('/') }}alt/plugins/fontawesome-free/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', 'Segoe UI', Arial, sans-serif; font-size: 13px; color: #1f2937; background: #f1f5f9; }

        @page { size: A4; margin: 12mm; }

        .chalan-box { width: 100%; max-width: 800px; margin: 24px auto; background: #fff; padding: 28px; box-shadow: 0 4px 20px rgba(0,0,0,.08); }

        .ch-tag { display: inline-block; background: #198754; color: #fff; font-size: 11px; font-weight: bold; letter-spacing: 2px; padding: 4px 14px; border-radius: 4px; -webkit-print-color-adjust: exact; print-color-adjust: exact; }

        .ch-header { display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 3px solid #198754; padding-bottom: 16px; margin-bottom: 18px; }
        .ch-header .company-title { font-size: 22px; font-weight: bold; color: #198754; }
        .ch-header .company-addr { font-size: 12px; color: #6b7280; margin-top: 4px; max-width: 320px; }
        .ch-header .ch-meta { text-align: right; }
        .ch-header .ch-meta .label { font-size: 20px; font-weight: bold; letter-spacing: 2px; color: #198754; }
        .ch-header .ch-meta .row { font-size: 12.5px; margin-top: 4px; color: #374151; }

        .info-row { display: flex; justify-content: space-between; gap: 20px; margin-bottom: 18px; }
        .info-box { font-size: 12.5px; line-height: 1.7; flex: 1; }
        .info-box .heading { font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #fff; background: #198754; padding: 5px 10px; border-radius: 4px 4px 0 0; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        .info-box .body { border: 1px solid #cbd5e1; border-top: none; padding: 10px 12px; border-radius: 0 0 4px 4px; }

        table { width: 100%; border-collapse: collapse; margin-bottom: 18px; }
        table th, table td { border: 1px solid #cbd5e1; padding: 8px 10px; }
        table thead th { background: #198754 !important; color: #fff !important; font-size: 12px; text-align: center; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .totals .label { text-align: right; font-weight: bold; }
        .totals .grand td { background: #f0fdf4 !important; font-size: 14px; font-weight: bold; -webkit-print-color-adjust: exact; print-color-adjust: exact; }

        .signatures { display: flex; justify-content: space-between; gap: 20px; margin-top: 55px; }
        .sign-box { flex: 1; text-align: center; font-size: 12px; color: #374151; }
        .sign-line { border-top: 1.5px solid #374151; margin: 0 14px 6px; padding-top: 30px; }

        .ch-footer { text-align: center; margin-top: 26px; font-size: 11.5px; color: #9ca3af; border-top: 1px solid #e5e7eb; padding-top: 12px; }

        .print-bar { text-align: center; margin: 18px 0; }
        .btn-print { background: #198754; color: #fff; border: none; padding: 10px 26px; border-radius: 6px; font-size: 14px; cursor: pointer; }

        tr { page-break-inside: avoid; }
        thead { display: table-header-group; }

        @media print {
            body { background: #fff; }
            .chalan-box { box-shadow: none; margin: 0; max-width: 100%; padding: 0; }
            .print-bar { display: none; }
            table th, table td { border: 1px solid #000 !important; }
            table thead th { background: #198754 !important; color: #fff !important; }
        }
    </style>
</head>
<body>
@php
    // (logic unchanged)
    $shippingCost = $order->delivery_cost ?? $ws->shipping_charge ?? 150;
    $totalWithShipping = $order->subtotal + $shippingCost;
@endphp

<div class="chalan-box">

    <!-- HEADER -->
    <div class="ch-header">
        <div>
            @if($ws->logo())
                <img src="{{ route('imagecache', ['template' => 'original', 'filename' => $ws->logo_alt()]) }}" height="48" style="margin-bottom:6px;">
            @endif
            <div class="company-title">{{ $ws->website_title }}</div>
            <div class="company-addr">{{ $ws->contact_address }}</div>
        </div>
        <div class="ch-meta">
            <div class="label">CHALAN</div>
            <div class="row"><strong>Chalan #:</strong> {{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</div>
            <div class="row"><strong>Date:</strong> {{ \Carbon\Carbon::parse($order->created_at)->format('d M, Y') }}</div>
        </div>
    </div>

    <!-- CUSTOMER + CHALAN INFO -->
    <div class="info-row">
        <div class="info-box">
            <div class="heading">Chalan To</div>
            <div class="body">
                <strong>{{ $order->name ?? optional($order->user)->name }}</strong><br>
                {{ $order->email ?? optional($order->user)->email }}<br>
                {{ $order->mobile ?? optional($order->user)->mobile }}<br>
                {{ $order->address_title ?? optional($order->user)->address }}
            </div>
        </div>
        <div class="info-box">
            <div class="heading">Chalan Info</div>
            <div class="body">
                <strong>Chalan #:</strong> {{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}<br>
                <strong>Order Date:</strong> {{ \Carbon\Carbon::parse($order->created_at)->format('d M, Y') }}<br>
                <strong>Status:</strong> {{ ucfirst($order->order_status ?? '') }}
            </div>
        </div>
    </div>

    <!-- ITEMS -->
    <table>
        <thead>
            <tr>
                <th style="width:48px;">SL</th>
                <th style="text-align:left;">Product Name</th>
                <th style="width:110px;">Price</th>
                <th style="width:70px;">Qty</th>
                <th style="width:130px;">Total</th>
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
                <td colspan="4" class="label">Shipping Cost</td>
                <td class="text-right">{{ number_format($shippingCost, 2) }}</td>
            </tr>
            <tr class="grand">
                <td colspan="4" class="label">Grand Total</td>
                <td class="text-right">{{ number_format($totalWithShipping, 2) }}</td>
            </tr>
        </tfoot>
    </table>

    <!-- SIGNATURES -->
    <div class="signatures">
        <div class="sign-box"><div class="sign-line"></div>Prepared By</div>
        <div class="sign-box"><div class="sign-line"></div>Checked By</div>
        <div class="sign-box"><div class="sign-line"></div>Customer Signature</div>
    </div>

    <div class="ch-footer">
        Chalan generated on {{ \Carbon\Carbon::now()->format('d M Y h:i A') }} &middot; Thank you for being with us.
    </div>

    <div class="print-bar">
        <button class="btn-print" onclick="window.print()"><i class="fa fa-print"></i> Print Chalan</button>
    </div>
</div>
</body>
</html>

