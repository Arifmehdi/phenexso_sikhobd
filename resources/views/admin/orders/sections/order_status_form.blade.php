@php
    // Amount currently held from the customer (payments + advances − refunds)
    $paidSoFar = round($order->paid(), 2);
    $advanceSoFar = round($order->advancePaid(), 2);
@endphp

<div class="card shadow">
    <div class="card-header">
        <h3 class="card-title">
        Order Status
        </h3>
    </div>
    <form action="{{ route('admin.orderStatus',$order->id)}}" method="post" id="orderStatusForm">
        @csrf
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <select name="order_status" id="order_status" class="form-control">
                            <option value="">order status</option>
                            @foreach (config('parameter.order_status') as $item)
                                <option value="{{ $item }}" {{ $item == $order->order_status || ($item == 'cancelled' && $order->order_status == 'canceled') ? 'selected' : ' '}}>{{ ucfirst($item) }}</option>
                            @endforeach
                        </select>
                        @error('order_status')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-6">
                <button type="submit" class="form-control btn btn-primary btn-block">Submit</button>
                </div>

                <div class="col-12">
                    {{-- Shown when "Cancelled" is selected and the customer has paid money --}}
                    <div id="cancelRefundWarning" class="alert alert-warning mb-0 mt-1" style="display: none;">
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>Refund required:</strong>
                        The customer has already paid <strong>৳{{ number_format($paidSoFar, 2) }}</strong>
                        @if($advanceSoFar > 0)
                            (including advance of ৳{{ number_format($advanceSoFar, 2) }})
                        @endif
                        for this order. If you cancel it, this amount must be <strong>returned to the customer</strong>.
                        A refund form will appear on this page after cancellation, and the refund will be tracked in the activity log.
                    </div>
                </div>

            </div>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var paidSoFar = {{ $paidSoFar }};
        var statusSelect = document.getElementById('order_status');
        var warning = document.getElementById('cancelRefundWarning');
        var statusForm = document.getElementById('orderStatusForm');

        function isCancel(value) {
            return value === 'cancelled' || value === 'canceled';
        }

        function toggleWarning() {
            if (isCancel(statusSelect.value) && paidSoFar > 0) {
                warning.style.display = 'block';
            } else {
                warning.style.display = 'none';
            }
        }

        statusSelect.addEventListener('change', toggleWarning);
        toggleWarning(); // in case "Cancelled" is already the selected option on page load

        statusForm.addEventListener('submit', function (e) {
            if (isCancel(statusSelect.value) && paidSoFar > 0) {
                if (!confirm('This order has ৳' + paidSoFar.toFixed(2) + ' paid by the customer.\nIf you cancel, this amount must be refunded.\n\nAre you sure you want to cancel this order?')) {
                    e.preventDefault();
                }
            }
        });
    });
</script>
