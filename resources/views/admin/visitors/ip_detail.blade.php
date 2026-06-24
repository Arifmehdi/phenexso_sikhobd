@extends('admin.master')
@section('title', 'IP Detail: ' . $ip)

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"><i class="fas fa-network-wired text-primary mr-2"></i>IP: {{ $ip }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.visitors.index') }}">Visitors</a></li>
                    <li class="breadcrumb-item active">{{ $ip }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
<div class="container-fluid">

    <div class="row">
        <div class="col-md-4">
            <div class="card card-primary">
                <div class="card-header"><h3 class="card-title">IP Summary</h3></div>
                <div class="card-body">
                    <table class="table table-sm table-borderless">
                        <tr><th>IP Address</th><td><code>{{ $ip }}</code></td></tr>
                        <tr><th>Total Hits</th><td><span class="badge badge-danger">{{ number_format($totalHits) }}</span></td></tr>
                        <tr><th>First Seen</th><td>{{ $firstSeen ? \Carbon\Carbon::parse($firstSeen)->format('d M Y H:i') : '-' }}</td></tr>
                        <tr><th>Last Seen</th><td>{{ $lastSeen ? \Carbon\Carbon::parse($lastSeen)->diffForHumans() : '-' }}</td></tr>
                    </table>
                    @if($logs->first())
                    <hr>
                    <table class="table table-sm table-borderless">
                        <tr><th>Browser</th><td>{{ $logs->first()->browser }}</td></tr>
                        <tr><th>Platform</th><td>{{ $logs->first()->platform }}</td></tr>
                        <tr><th>Device</th><td>{{ ucfirst($logs->first()->device_type) }}</td></tr>
                    </table>
                    <hr>
                    <p class="text-muted small mb-0"><strong>User Agent:</strong><br>{{ $logs->first()->user_agent }}</p>
                    @endif
                </div>
                <div class="card-footer">
                    <a href="{{ route('admin.visitors.index') }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to All Visitors
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Visit History</h3></div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-sm table-striped mb-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>URL</th>
                                    <th>Method</th>
                                    <th>Referer</th>
                                    <th>User</th>
                                    <th>Time</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($logs as $log)
                            <tr>
                                <td>{{ $log->id }}</td>
                                <td style="max-width:250px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" title="{{ $log->url }}">
                                    <small>{{ $log->url }}</small>
                                </td>
                                <td><span class="badge badge-{{ $log->method=='GET'?'success':'warning' }}">{{ $log->method }}</span></td>
                                <td style="max-width:150px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" title="{{ $log->referer }}">
                                    <small>{{ $log->referer ?? '-' }}</small>
                                </td>
                                <td>
                                    @if($log->user_id)
                                        <span class="badge badge-info">User #{{ $log->user_id }}</span>
                                    @else
                                        <span class="text-muted small">Guest</span>
                                    @endif
                                </td>
                                <td><small>{{ $log->created_at->format('d M Y H:i:s') }}</small></td>
                            </tr>
                            @empty
                            <tr><td colspan="6" class="text-center py-4 text-muted">No records.</td></tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">{{ $logs->links() }}</div>
            </div>
        </div>
    </div>

</div>
</section>
@endsection
