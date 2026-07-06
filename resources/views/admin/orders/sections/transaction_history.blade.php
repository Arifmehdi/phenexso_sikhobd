<div class="card shadow">
    <div class="card-header">
            <h3 class="card-title">
            Transaction History
        </h3>
    </div>
    <div class="card-body">
    <div class="row">
    <div class="col-12">
    <div class="table-responsive">
        <table class="table table-sm table-striped table-bordered">
            <thead>
            <tr>
                <th>SL</th>
                <th>Type</th>
                <th>Payment Status</th>
                <th>Payment Date</th>
                <th>Method</th>
                <th>Transaction Id</th>
                <th>Amount</th>
            </tr>
            </thead>
        <tbody>

            @foreach($order->payments as $payment)
            <tr class="{{ $payment->payment_type == 'refund' ? 'table-danger' : '' }}">
                <td>{{$payment->id}}</td>
                <td>
                    @if($payment->payment_type == 'advance')
                        <span class="badge badge-info">Advance</span>
                    @elseif($payment->payment_type == 'refund')
                        <span class="badge badge-danger">Refund</span>
                    @else
                        <span class="badge badge-success">Payment</span>
                    @endif
                </td>
                <td>{{ Str::ucfirst($payment->payment_status) }}</td>
                <td>{{$payment->payment_date}}</td>
                <td>{{ Str::ucfirst($payment->payment_method) }}</td>
                <td>{{$payment->transaction_id}}</td>
                <td>{{ $payment->payment_type == 'refund' ? '-' : '' }}{{$payment->paid_amount}}</td>
            </tr>
            @endforeach
        <tbody>
        </table>
    </div>
    </div>
    </div>
    </div>
</div>