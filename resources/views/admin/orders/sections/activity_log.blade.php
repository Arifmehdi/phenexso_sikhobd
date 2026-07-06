<div class="card shadow mt-2">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-history"></i> Activity Log</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Date &amp; Time</th>
                                <th>Activity</th>
                                <th>Description</th>
                                <th>Amount</th>
                                <th>By</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($order->activities as $activity)
                                @php
                                    $badges = [
                                        'payment'         => 'badge-success',
                                        'advance_payment' => 'badge-info',
                                        'refund'          => 'badge-danger',
                                        'refund_due'      => 'badge-warning',
                                        'status_change'   => 'badge-secondary',
                                    ];
                                @endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $activity->created_at->format('d M Y, h:i A') }}</td>
                                    <td>
                                        <span class="badge {{ $badges[$activity->activity_type] ?? 'badge-light' }}">
                                            {{ ucwords(str_replace('_', ' ', $activity->activity_type)) }}
                                        </span>
                                    </td>
                                    <td>{{ $activity->description }}</td>
                                    <td>{{ $activity->amount !== null ? '৳' . number_format($activity->amount, 2) : '-' }}</td>
                                    <td>{{ $activity->user->name ?? 'System' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">No activity recorded yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
