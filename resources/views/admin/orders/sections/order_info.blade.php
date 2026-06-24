<div class="row">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-body text-center">
                <img  class="w3-100 w3-round" src="{{ route('imagecache', [ 'template'=>'cpxxxs','filename' => $ws->logo_alt() ]) }}" alt="Hubli Bd Logo">
                <address>
                {{$ws->website_title}}<br>
                {{$ws->contact_address}}<br>
                Phone: {{$ws->contact_mobile}}<br>
                Email: {{$ws->contact_email}}
                </address>
            </div>
        </div>
    </div>
<div class="col-md-6">
    <div class="card shadow">
        <div class="card-body">
        <address>
            <strong>Order Info</strong><br>

            Order Id: {{ $order->id }}<br>

            Order Date: {{ $order->created_at->format('d/m/Y') }}<br>

            Order By: 
            {{ $order->name ?? optional($order->user)->name }} 
            @if($order->mobile || optional($order->user)->mobile)
            ({{ $order->mobile ?? optional($order->user)->mobile }})<br>
            @endif 

            @if($order->email)
            Email:
            {{ $order->email ?? optional($order->user)->email }}<br>
            @endif

            <div class="mt-3 pt-2 border-top">
                <strong class="text-primary"><i class="fas fa-credit-card"></i> Payment Info</strong><br>
                Payment Type:
                <span class="badge {{ $order->payment_method == 'online' ? 'bg-info' : 'bg-secondary' }}">
                    {{ $order->payment_method == 'online' ? 'Online' : strtoupper($order->payment_method ?? 'COD') }}
                </span><br>
                @if($order->payment_trx_id)
                    Transaction ID: <strong>{{ $order->payment_trx_id }}</strong><br>
                @endif
                Payment Status:
                <span class="badge {{ $order->payment_status == 'paid' ? 'bg-success' : ($order->payment_status == 'pending' ? 'bg-warning' : 'bg-danger') }}">
                    {{ ucfirst($order->payment_status) }}
                </span>
            </div>

            @if($order->has_course)
                <div class="mt-3 pt-2 border-top">
                    <strong class="text-primary"><i class="fas fa-user-graduate"></i> Student Registration Info</strong><br>
                    Class: {{ $order->student_class }}<br>
                    Occupation: {{ $order->occupation }}<br>
                    Academic Status: {{ $order->last_academic_status }}<br>
                    <span class="badge {{ $order->admin_approval == 'approved' ? 'bg-success' : 'bg-warning' }}">
                        Approval: {{ ucfirst($order->admin_approval) }}
                    </span>
                </div>
            @endif
        </address>
        </div>
    </div>
</div>
</div>