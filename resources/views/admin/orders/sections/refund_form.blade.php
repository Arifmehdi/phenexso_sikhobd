@php
    $refundable = round($order->paid(), 2);
@endphp

<form action="{{ route('admin.orderRefund', $order) }}" method="post">
    @csrf

    <div class="card shadow border-danger">
        <div class="card-header bg-danger">
            <h3 class="card-title text-white"><i class="fas fa-undo-alt"></i> Return Advance / Refund</h3>
        </div>
        <div class="card-body">

            <div class="alert alert-warning py-2 mb-2">
                This order is <strong>canceled</strong> and the customer has paid
                <strong>৳{{ number_format($refundable, 2) }}</strong>
                (Advance: ৳{{ number_format($order->advancePaid(), 2) }}).
                Please return the money and record it below.
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card shadow" style="margin-bottom: 5px;">
                        <div class="card-body">

                            <div class="form-group input-group-sm w3-light-gray row mb-1">
                                <label for="refund_date" class="col-sm-5 col-form-label">Refund Date</label>
                                <div class="col-sm-7">
                                    <input type="date" class="form-control mt-1 form-control-sm" id="refund_date" value="{{ old('refund_date') ?: date('Y-m-d') }}" name="refund_date" required>
                                </div>
                                @error('refund_date')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group input-group-sm mb-1 row w3-light-gray">
                                <label for="refund_method" class="col-sm-5 col-form-label">Refund Method</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control mt-1 form-control-sm" id="refund_method" value="{{ old('refund_method') }}" placeholder="refund method" list="refund_methods" name="refund_method" required>
                                    <datalist id="refund_methods">
                                        @foreach (config('parameter.payment_method') as $item)
                                            <option value="{{ $item }}">{{ ucfirst($item) }}</option>
                                        @endforeach
                                    </datalist>
                                </div>
                                @error('refund_method')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group input-group-sm row w3-light-gray mb-1">
                                <label for="refund_transaction_id" class="col-sm-5 col-form-label">Trans ID</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control bg-light mt-1 form-control-sm" id="refund_transaction_id" name="transaction_id" value="{{ old('transaction_id') }}" placeholder="Transaction Id">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card shadow" style="margin-bottom: 5px;">
                        <div class="card-body">

                            <div class="form-group input-group-sm mb-1 row w3-light-gray">
                                <label for="refund_amount" class="col-sm-5 col-form-label">Refund Amount</label>
                                <div class="col-sm-7">
                                    <input type="number" class="form-control mt-1 form-control-sm" id="refund_amount" value="{{ old('refund_amount') ?: $refundable }}" name="refund_amount" min="0.01" step="any" max="{{ $refundable }}" placeholder="Refund Amount" required>
                                    <small class="text-muted">Refundable: ৳{{ number_format($refundable, 2) }}</small>
                                    @error('refund_amount')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group input-group-sm row w3-light-gray mb-1">
                                <label for="refund_note" class="col-sm-5 col-form-label">Note</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control bg-light mt-1 form-control-sm" placeholder="Note" id="refund_note" value="{{ old('note') }}" name="note">
                                </div>
                            </div>

                            <div class="form-group input-group-sm row w3-light-gray mb-1">
                                <div class="col-sm-5"></div>
                                <div class="col-sm-7">
                                    <button type="submit" class="btn btn-danger btn-block btn-sm" onclick="return confirm('Return ৳' + document.getElementById('refund_amount').value + ' to the customer?')">Return Money</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
