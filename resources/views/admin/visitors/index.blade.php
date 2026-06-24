@extends('admin.master')
@section('title', 'Visitor Tracking')

@section('body')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"><i class="fas fa-eye text-primary mr-2"></i>Visitor Tracking</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Visitors</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
<div class="container-fluid">

    {{-- Stats Cards --}}
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ number_format($totalVisits) }}</h3>
                    <p>Total Page Visits</p>
                </div>
                <div class="icon"><i class="fas fa-chart-line"></i></div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ number_format($todayVisits) }}</h3>
                    <p>Today's Visits</p>
                </div>
                <div class="icon"><i class="fas fa-calendar-day"></i></div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ number_format($uniqueIPs) }}</h3>
                    <p>Unique IPs (All Time)</p>
                </div>
                <div class="icon"><i class="fas fa-network-wired"></i></div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ number_format($todayUniqueIPs) }}</h3>
                    <p>Unique IPs Today</p>
                </div>
                <div class="icon"><i class="fas fa-user-check"></i></div>
            </div>
        </div>
    </div>

    {{-- Charts Row --}}
    <div class="row">
        {{-- Daily Traffic Chart --}}
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-chart-bar mr-1"></i> Daily Traffic (Last 14 Days)</h3>
                </div>
                <div class="card-body">
                    <canvas id="dailyChart" height="80"></canvas>
                </div>
            </div>
        </div>

        {{-- Device & Browser Stats --}}
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header"><h3 class="card-title"><i class="fas fa-mobile-alt mr-1"></i> Device Types</h3></div>
                <div class="card-body p-0">
                    <table class="table table-sm mb-0">
                        @foreach($deviceStats as $d)
                        <tr>
                            <td>
                                @if($d->device_type == 'mobile') <i class="fas fa-mobile-alt text-success"></i>
                                @elseif($d->device_type == 'tablet') <i class="fas fa-tablet-alt text-warning"></i>
                                @else <i class="fas fa-desktop text-info"></i>
                                @endif
                                {{ ucfirst($d->device_type ?? 'Unknown') }}
                            </td>
                            <td class="text-right"><span class="badge badge-info">{{ number_format($d->total) }}</span></td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
            <div class="card">
                <div class="card-header"><h3 class="card-title"><i class="fas fa-globe mr-1"></i> Browsers</h3></div>
                <div class="card-body p-0">
                    <table class="table table-sm mb-0">
                        @foreach($browserStats as $b)
                        <tr>
                            <td>{{ $b->browser ?? 'Unknown' }}</td>
                            <td class="text-right"><span class="badge badge-primary">{{ number_format($b->total) }}</span></td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Top Pages --}}
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header"><h3 class="card-title"><i class="fas fa-file-alt mr-1"></i> Top 10 Pages</h3></div>
                <div class="card-body p-0">
                    <table class="table table-sm table-striped mb-0">
                        <thead><tr><th>URL</th><th class="text-right">Hits</th></tr></thead>
                        <tbody>
                        @foreach($topPages as $page)
                        <tr>
                            <td style="max-width:300px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" title="{{ $page->url }}">
                                {{ $page->url }}
                            </td>
                            <td class="text-right"><span class="badge badge-success">{{ number_format($page->total) }}</span></td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Top IPs --}}
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header"><h3 class="card-title"><i class="fas fa-network-wired mr-1"></i> Top 10 IPs</h3></div>
                <div class="card-body p-0">
                    <table class="table table-sm table-striped mb-0">
                        <thead><tr><th>IP Address</th><th>Last Seen</th><th class="text-right">Hits</th></tr></thead>
                        <tbody>
                        @foreach($topIPs as $ipRow)
                        <tr>
                            <td>
                                <a href="{{ route('admin.visitors.ip', $ipRow->ip_address) }}">{{ $ipRow->ip_address }}</a>
                            </td>
                            <td class="text-muted small">{{ \Carbon\Carbon::parse($ipRow->last_seen)->diffForHumans() }}</td>
                            <td class="text-right"><span class="badge badge-warning">{{ number_format($ipRow->total) }}</span></td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter + Log Table --}}
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title"><i class="fas fa-list mr-1"></i> Visitor Log</h3>
            <div>
                <button class="btn btn-sm btn-outline-secondary" data-toggle="collapse" data-target="#filterBox">
                    <i class="fas fa-filter"></i> Filter
                </button>
                <button class="btn btn-sm btn-outline-danger ml-2" data-toggle="modal" data-target="#clearModal">
                    <i class="fas fa-trash"></i> Clear Old
                </button>
            </div>
        </div>

        <div class="collapse {{ request()->hasAny(['ip','date_from','date_to','device','browser']) ? 'show' : '' }}" id="filterBox">
            <div class="card-body border-bottom bg-light">
                <form method="GET" class="form-inline flex-wrap">
                    <input type="text" name="ip" class="form-control form-control-sm mr-2 mb-2" placeholder="IP Address" value="{{ request('ip') }}">
                    <input type="date" name="date_from" class="form-control form-control-sm mr-2 mb-2" value="{{ request('date_from') }}">
                    <input type="date" name="date_to" class="form-control form-control-sm mr-2 mb-2" value="{{ request('date_to') }}">
                    <select name="device" class="form-control form-control-sm mr-2 mb-2">
                        <option value="">All Devices</option>
                        <option value="desktop" {{ request('device')=='desktop'?'selected':'' }}>Desktop</option>
                        <option value="mobile" {{ request('device')=='mobile'?'selected':'' }}>Mobile</option>
                        <option value="tablet" {{ request('device')=='tablet'?'selected':'' }}>Tablet</option>
                    </select>
                    <select name="browser" class="form-control form-control-sm mr-2 mb-2">
                        <option value="">All Browsers</option>
                        @foreach($browserStats as $b)
                        <option value="{{ $b->browser }}" {{ request('browser')==$b->browser?'selected':'' }}>{{ $b->browser }}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-sm btn-primary mb-2 mr-2"><i class="fas fa-search"></i> Search</button>
                    <a href="{{ route('admin.visitors.index') }}" class="btn btn-sm btn-secondary mb-2">Reset</a>
                </form>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-sm table-striped table-hover mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>IP Address</th>
                            <th>URL</th>
                            <th>Browser</th>
                            <th>Platform</th>
                            <th>Device</th>
                            <th>Referer</th>
                            <th>User</th>
                            <th>Time</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($logs as $log)
                    <tr>
                        <td>{{ $log->id }}</td>
                        <td>
                            <a href="{{ route('admin.visitors.ip', $log->ip_address) }}" class="badge badge-secondary">
                                {{ $log->ip_address }}
                            </a>
                        </td>
                        <td style="max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" title="{{ $log->url }}">
                            <small>{{ $log->url }}</small>
                        </td>
                        <td><small>{{ $log->browser }}</small></td>
                        <td><small>{{ $log->platform }}</small></td>
                        <td>
                            @if($log->device_type == 'mobile')
                                <i class="fas fa-mobile-alt text-success" title="Mobile"></i>
                            @elseif($log->device_type == 'tablet')
                                <i class="fas fa-tablet-alt text-warning" title="Tablet"></i>
                            @else
                                <i class="fas fa-desktop text-info" title="Desktop"></i>
                            @endif
                        </td>
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
                        <td><small title="{{ $log->created_at }}">{{ $log->created_at->diffForHumans() }}</small></td>
                    </tr>
                    @empty
                    <tr><td colspan="9" class="text-center text-muted py-4">No visitor logs found.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $logs->links() }}
        </div>
    </div>

</div>
</section>

{{-- Clear Modal --}}
<div class="modal fade" id="clearModal" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title">Clear Old Logs</h5></div>
            <form method="POST" action="{{ route('admin.visitors.clear') }}">
                @csrf
                <div class="modal-body">
                    <label>Delete logs older than:</label>
                    <div class="input-group">
                        <input type="number" name="days" class="form-control" value="30" min="1">
                        <div class="input-group-append"><span class="input-group-text">days</span></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger btn-sm">Clear</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
const dailyLabels = @json($dailyStats->pluck('date'));
const dailyData   = @json($dailyStats->pluck('total'));

new Chart(document.getElementById('dailyChart'), {
    type: 'bar',
    data: {
        labels: dailyLabels,
        datasets: [{
            label: 'Page Visits',
            data: dailyData,
            backgroundColor: 'rgba(60,141,188,0.7)',
            borderColor: 'rgba(60,141,188,1)',
            borderWidth: 1,
        }]
    },
    options: {
        responsive: true,
        scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
    }
});
</script>
@endpush

