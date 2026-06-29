@extends('website.layouts.sikhobd')

@section('title', 'ই-বুক লাইব্রেরি — ' . ($ws->website_title ?? 'Qalam HR'))

@push('css')
<style>
    .ebook-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
    }
    @media (max-width: 991px) {
        .ebook-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 575px) {
        .ebook-grid { grid-template-columns: 1fr; }
    }

    .ebook-thumb {
        aspect-ratio: 260 / 372;
        background: #f8fafc;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        border-bottom: 1px solid var(--border);
    }
    .ebook-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    .ebook-card:hover .ebook-thumb img {
        transform: scale(1.05);
    }
    .ebook-preview-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        background: rgba(255,255,255,0.95);
        color: var(--primary);
        font-size: 11px;
        font-weight: 700;
        padding: 4px 12px;
        border-radius: 20px;
        z-index: 15;
        display: flex;
        align-items: center;
        gap: 4px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .ebook-preview-badge:hover {
        background: var(--accent);
        color: #fff;
    }
    .ebook-card .shop-actions {
        position: absolute;
        bottom: 10px;
        left: 0;
        right: 0;
        display: flex;
        justify-content: center;
        gap: 8px;
        opacity: 0;
        transform: translateY(10px);
        transition: all 0.3s ease;
        z-index: 10;
        pointer-events: none;
    }
    .ebook-card:hover .shop-actions {
        opacity: 1;
        transform: translateY(0);
        pointer-events: auto;
    }
    .ebook-card .shop-action-btn {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: #fff;
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border);
        transition: all 0.2s;
        cursor: pointer;
    }
    .ebook-card .shop-action-btn:hover {
        background: var(--accent);
        color: #fff;
        border-color: var(--accent);
    }
    .ebook-card .shop-action-btn.ebook-preview-btn {
        background: #fef3c7;
        color: #d97706;
        border-color: #fbbf24;
    }
    .ebook-card .shop-action-btn.ebook-preview-btn:hover {
        background: #d97706;
        color: #fff;
        border-color: #d97706;
    }
    .ebook-card .in-cart-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        background: #28a745;
        color: #fff;
        font-size: 11px;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 20px;
        z-index: 5;
        display: flex;
        align-items: center;
        gap: 4px;
        box-shadow: 0 2px 8px rgba(40, 167, 69, 0.3);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .ebook-card .in-cart-overlay {
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(255,255,255,0.08);
        pointer-events: none;
        z-index: 1;
    }
    .ebook-card.in-cart-card {
        border-color: #28a745;
        box-shadow: 0 0 0 1px #28a745, var(--shadow-md);
    }
    .ebook-card.in-cart-card .ebook-thumb {
        background: #f0fff4;
    }
    .ebook-card .shop-cart-btn.in-cart-state,
    .ebook-card .shop-buy-btn.in-cart-state {
        background: #e8f5e9;
        color: #28a745;
        border-color: #28a745;
        cursor: default;
    }
    .ebook-card .shop-action-btn.in-cart-state {
        background: #28a745;
        color: #fff;
        border-color: #28a745;
        cursor: default;
    }
    .ebook-card .go-to-cart-link {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        padding: 6px 12px;
        background: #28a745;
        color: #fff;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s;
        flex: 1;
    }
    .ebook-card .go-to-cart-link:hover {
        background: #218838;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(40,167,69,0.3);
    }
    .ebook-card .shop-cart-btn,
    .ebook-card .shop-buy-btn {
        padding: 8px 12px;
        border: none;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        text-transform: capitalize;
        letter-spacing: 0.3px;
        flex: 1;
    }
    .ebook-card .shop-cart-btn {
        background: #f0f0f0;
        color: var(--primary);
        border: 1px solid var(--border);
    }
    .ebook-card .shop-cart-btn:hover {
        background: var(--primary);
        color: #fff;
        border-color: var(--primary);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .ebook-card .shop-buy-btn {
        background: var(--accent);
        color: #fff;
    }
    .ebook-card .shop-buy-btn:hover {
        background: var(--primary);
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0,0,0,0.15);
    }
    .ebook-card .shop-buy-btn:disabled,
    .ebook-card .shop-buy-btn.disabled {
        background: #ccc;
        color: #666;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }

    /* ── Custom Preview Modal ── */
    .ebx-modal-overlay {
        display: none; position: fixed; inset: 0;
        background: rgba(29,24,57,.72); backdrop-filter: blur(6px);
        z-index: 5000; align-items: center; justify-content: center; padding: 20px;
    }
    .ebx-modal-overlay.open { display: flex; }
    .ebx-modal-box {
        background: #fff; border-radius: 16px; overflow: hidden;
        width: 100%; max-width: 880px; height: 540px; max-height: 90vh;
        display: flex; flex-direction: column;
        box-shadow: 0 32px 80px rgba(43,37,83,.35);
    }
    .ebx-modal-head {
        display: flex; align-items: center; justify-content: space-between;
        padding: 14px 20px; border-bottom: 1px solid var(--border);
        background: var(--bg-muted); flex-shrink: 0;
    }
    .ebx-modal-head h4 { margin: 0; font-size: 15px; font-weight: 700; color: var(--primary); }
    .ebx-modal-close {
        width: 32px; height: 32px; background: #fff; border: 1px solid var(--border);
        border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center;
        font-size: 13px; color: var(--text-muted); transition: background .2s;
    }
    .ebx-modal-close:hover { background: var(--accent); color: #fff; border-color: var(--accent); }
    .ebx-modal-body { display: flex; flex: 1; overflow: hidden; }
    .ebx-modal-pdf { flex: 1; background: #1e293b; position: relative; }
    .ebx-modal-loader { position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%); text-align: center; color: #fff; }
    .ebx-modal-frame { width: 100%; height: 100%; border: none; display: none; }
    .ebx-modal-side {
        width: 240px; flex-shrink: 0; background: var(--bg-soft);
        border-left: 1px solid var(--border); padding: 18px;
        display: flex; flex-direction: column; gap: 10px; overflow-y: auto;
    }
    .ebx-btn-buy {
        display: inline-flex; align-items: center; justify-content: center; gap: 8px;
        padding: 11px 14px; background: var(--accent); color: #fff;
        border-radius: 10px; font-size: 13px; font-weight: 700; text-decoration: none;
        transition: background .2s;
    }
    .ebx-btn-buy:hover { background: var(--accent-light, #ff6b85); color: #fff; }
    .ebx-btn-detail {
        display: inline-flex; align-items: center; justify-content: center; gap: 6px;
        padding: 10px 14px; background: #fff; color: var(--primary);
        border: 1.5px solid var(--border); border-radius: 10px;
        font-size: 13px; font-weight: 600; text-decoration: none;
        transition: border-color .2s, background .2s;
    }
    .ebx-btn-detail:hover { border-color: var(--primary); background: var(--bg-muted); color: var(--primary); }
    @media (max-width: 640px) {
        .ebx-modal-box { height: auto; max-height: 92vh; }
        .ebx-modal-side { width: 100%; max-height: 45vh; }
        .ebx-modal-body { flex-direction: column; }
        .ebx-modal-pdf { min-height: 300px; }
    }

    /* ════════ Rokomari-style page layout ════════ */
    .ebx-page { padding: 24px 0 60px; background: var(--bg-soft); }

    /* Popular carousel */
    .ebx-pop { background:#fff; border:1px solid var(--border); border-radius:var(--radius-lg); padding:18px 20px; margin-bottom:24px; }
    .ebx-pop-head { display:flex; align-items:center; justify-content:space-between; margin-bottom:14px; }
    .ebx-pop-head h3 { margin:0; font-size:17px; font-weight:800; color:var(--primary); display:flex; align-items:center; gap:8px; }
    .ebx-pop-nav { display:flex; gap:6px; }
    .ebx-pop-btn { width:32px; height:32px; border-radius:50%; border:1px solid var(--border); background:#fff; color:var(--primary); cursor:pointer; transition:background .2s; }
    .ebx-pop-btn:hover { background:var(--accent); color:#fff; border-color:var(--accent); }
    .ebx-pop-track { display:flex; gap:16px; overflow-x:auto; scroll-behavior:smooth; padding-bottom:6px; scrollbar-width:thin; }
    .ebx-pop-track::-webkit-scrollbar { height:6px; }
    .ebx-pop-track::-webkit-scrollbar-thumb { background:var(--border); border-radius:3px; }
    .ebx-pop-item { flex:0 0 120px; text-decoration:none; }
    .ebx-pop-cover { position:relative; aspect-ratio:3/4; border-radius:8px; overflow:hidden; background:var(--bg-muted); box-shadow:0 4px 12px rgba(43,37,83,.12); }
    .ebx-pop-cover img { width:100%; height:100%; object-fit:cover; }
    .ebx-pop-ph { width:100%; height:100%; display:flex; align-items:center; justify-content:center; font-size:26px; color:var(--primary); opacity:.25; }
    .ebx-pop-disc { position:absolute; top:6px; left:6px; background:var(--accent); color:#fff; font-size:10px; font-weight:700; padding:2px 7px; border-radius:20px; }
    .ebx-pop-name { font-size:12px; font-weight:600; color:var(--primary); margin-top:8px; line-height:1.3;
        display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }
    .ebx-pop-price { font-size:13px; font-weight:800; color:var(--accent); margin-top:3px; }

    /* Breadcrumb + result head */
    .ebx-crumbs { font-size:13px; color:var(--text-muted); margin-bottom:10px; }
    .ebx-crumbs a { color:var(--text-muted); text-decoration:none; }
    .ebx-crumbs a:hover { color:var(--accent); }
    .ebx-crumbs i { font-size:9px; margin:0 4px; }
    .ebx-crumbs span { color:var(--primary); font-weight:600; }
    .ebx-result-head { display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px; margin-bottom:20px; }
    .ebx-result-head h2 { margin:0; font-size:22px; font-weight:800; color:var(--primary); }
    .ebx-result-head h2 small { font-size:14px; font-weight:500; color:var(--text-muted); }
    .ebx-sort select { padding:9px 14px; border:1px solid var(--border); border-radius:10px; font-size:13px; color:var(--primary); background:#fff; cursor:pointer; }

    /* Layout: sidebar + main */
    .ebx-layout { display:grid; grid-template-columns:260px 1fr; gap:24px; align-items:start; }
    @media(max-width:991px){ .ebx-layout{ grid-template-columns:1fr; } }

    /* Filter sidebar */
    .ebx-filters { position:sticky; top:90px; }
    @media(max-width:991px){ .ebx-filters{ position:static; } }
    .ebx-fbox { background:#fff; border:1px solid var(--border); border-radius:var(--radius-lg); padding:14px 16px; margin-bottom:14px; }
    .ebx-search { display:flex; align-items:center; gap:8px; }
    .ebx-search i { color:var(--text-muted); font-size:13px; }
    .ebx-search input { flex:1; border:none; outline:none; font-size:13px; background:transparent; color:var(--primary); }
    .ebx-ftitle { font-size:14px; font-weight:800; color:var(--primary); margin-bottom:10px; padding-bottom:8px; border-bottom:1px solid var(--border); }
    .ebx-flist { display:flex; flex-direction:column; }
    .ebx-flist.ebx-scroll { max-height:220px; overflow-y:auto; scrollbar-width:thin; }
    .ebx-fitem { display:flex; align-items:center; justify-content:space-between; gap:6px;
        padding:7px 2px; font-size:13px; color:var(--text-soft); text-decoration:none; border-radius:6px; transition:color .15s; }
    .ebx-fitem:hover { color:var(--accent); }
    .ebx-fitem.active { color:var(--accent); font-weight:700; }
    .ebx-fcount { font-size:11px; color:var(--text-muted); background:var(--bg-muted); padding:1px 7px; border-radius:20px; }
    .ebx-clear { display:inline-flex; align-items:center; gap:6px; font-size:13px; color:var(--accent); text-decoration:none; font-weight:600; padding:4px; }
    .ebx-clear:hover { text-decoration:underline; }

    /* Override grid to 4 cols in the main area */
    .ebx-main .ebook-grid { grid-template-columns:repeat(3,1fr); gap:18px; }
    @media(max-width:991px){ .ebx-main .ebook-grid{ grid-template-columns:repeat(3,1fr); } }
    @media(max-width:767px){ .ebx-main .ebook-grid{ grid-template-columns:repeat(2,1fr); gap:12px; } }
</style>
@endpush

@section('content')
<section class="ebx-page">
    <div class="container">

        {{-- Popular carousel --}}
       {{-- @if($popularEbooks->count() > 0)
        <div class="ebx-pop">
            <div class="ebx-pop-head">
                <h3><i class="fa-solid fa-fire" style="color:var(--accent);"></i> জনপ্রিয় ই-বুক</h3>
                <div class="ebx-pop-nav">
                    <button class="ebx-pop-btn" id="ebxPopPrev"><i class="fa-solid fa-chevron-left"></i></button>
                    <button class="ebx-pop-btn" id="ebxPopNext"><i class="fa-solid fa-chevron-right"></i></button>
                </div>
            </div>
            <div class="ebx-pop-track" id="ebxPopTrack">
                @foreach($popularEbooks as $p)
                @php $pDisc = ($p->discount>0 && $p->price>0) ? round($p->discount/$p->price*100) : 0; @endphp
                <a href="{{ route('ebooks.show', $p->id) }}" class="ebx-pop-item">
                    <div class="ebx-pop-cover">
                        @if($p->cover_image)<img src="{{ asset('storage/ebook_covers/'.$p->cover_image) }}" alt="">@else<div class="ebx-pop-ph"><i class="fa-solid fa-book"></i></div>@endif
                        @if($pDisc>0)<span class="ebx-pop-disc">{{ $pDisc }}%</span>@endif
                    </div>
                    <div class="ebx-pop-name">{{ Str::limit($p->title_bn ?? $p->title_en, 28) }}</div>
                    <div class="ebx-pop-price">৳{{ number_format($p->final_price,0) }}</div>
                </a>
                @endforeach
            </div>
        </div>
        @endif --}}

        {{-- Breadcrumb + result count --}}
        <div class="ebx-crumbs">
            <a href="{{ route('home') }}">হোম</a> <i class="fa-solid fa-chevron-right"></i>
            <span>ই-বুক</span>
        </div>
        <div class="ebx-result-head">
            <h2>ই-বুক <small>({{ $ebooks->total() }} টি বই)</small></h2>
            <form method="GET" class="ebx-sort">
                @foreach(request()->except(['sort','page']) as $k=>$v)<input type="hidden" name="{{ $k }}" value="{{ $v }}">@endforeach
                <select name="sort" onchange="this.form.submit()">
                    <option value="">সাজান: নতুন</option>
                    <option value="popular"    {{ request('sort')=='popular'?'selected':'' }}>জনপ্রিয়</option>
                    <option value="price_low"  {{ request('sort')=='price_low'?'selected':'' }}>দাম: কম থেকে বেশি</option>
                    <option value="price_high" {{ request('sort')=='price_high'?'selected':'' }}>দাম: বেশি থেকে কম</option>
                </select>
            </form>
        </div>

        <div class="ebx-layout">

            {{-- LEFT FILTER SIDEBAR --}}
            <aside class="ebx-filters">
                {{-- Search --}}
                <div class="ebx-fbox">
                    <form method="GET" class="ebx-search">
                        @foreach(request()->except(['q','page']) as $k=>$v)<input type="hidden" name="{{ $k }}" value="{{ $v }}">@endforeach
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="বই বা লেখক খুঁজুন...">
                    </form>
                </div>

                {{-- Category --}}
                <div class="ebx-fbox">
                    <div class="ebx-ftitle">বিষয়</div>
                    <div class="ebx-flist">
                        <a href="{{ route('ebooks.index', request()->except(['category','page'])) }}" class="ebx-fitem {{ !request('category')?'active':'' }}">সব বিষয়</a>
                        @foreach($categories as $cat)
                        <a href="{{ route('ebooks.index', array_merge(request()->except('page'),['category'=>$cat->id])) }}" class="ebx-fitem {{ request('category')==$cat->id?'active':'' }}">{{ $cat->name_bn ?? $cat->name_en }}</a>
                        @endforeach
                    </div>
                </div>

                {{-- Author --}}
                @if($authors->count() > 0)
                <div class="ebx-fbox">
                    <div class="ebx-ftitle">লেখক</div>
                    <div class="ebx-flist ebx-scroll">
                        <a href="{{ route('ebooks.index', request()->except(['author','page'])) }}" class="ebx-fitem {{ !request('author')?'active':'' }}">সব লেখক</a>
                        @foreach($authors as $a)
                        <a href="{{ route('ebooks.index', array_merge(request()->except('page'),['author'=>$a->author_name])) }}" class="ebx-fitem {{ request('author')==$a->author_name?'active':'' }}">{{ $a->author_name }} <span class="ebx-fcount">{{ $a->cnt }}</span></a>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Price --}}
                <div class="ebx-fbox">
                    <div class="ebx-ftitle">মূল্য</div>
                    <div class="ebx-flist">
                        @php $prices = ['0-100'=>'৳০ – ৳১০০','100-300'=>'৳১০০ – ৳৩০০','300-500'=>'৳৩০০ – ৳৫০০','500-plus'=>'৳৫০০+']; @endphp
                        <a href="{{ route('ebooks.index', request()->except(['price','page'])) }}" class="ebx-fitem {{ !request('price')?'active':'' }}">সব মূল্য</a>
                        @foreach($prices as $key=>$lbl)
                        <a href="{{ route('ebooks.index', array_merge(request()->except('page'),['price'=>$key])) }}" class="ebx-fitem {{ request('price')==$key?'active':'' }}">{{ $lbl }}</a>
                        @endforeach
                    </div>
                </div>

                @if(request()->hasAny(['q','category','author','price']))
                <a href="{{ route('ebooks.index') }}" class="ebx-clear"><i class="fa-solid fa-xmark"></i> ফিল্টার মুছুন</a>
                @endif
            </aside>

            {{-- MAIN GRID --}}
            <div class="ebx-main">
                <div class="ebook-grid">
                    @forelse($ebooks as $ebook)

                    @php $isInCart = in_array($ebook->id, $cartEbookIds ?? []); @endphp
                    <article class="card ebook-card {{ $isInCart ? 'in-cart-card' : '' }}" data-eid="{{ $ebook->id }}" style="border-radius: var(--radius-lg); overflow: hidden; border: 1px solid var(--border); transition: all 0.3s ease;">
                        <div class="ebook-thumb">
                            @if($isInCart)
                            <span class="in-cart-badge"><i class="fa-solid fa-check-circle"></i> In Cart</span>
                            @endif

                            @if($isInCart)<div class="in-cart-overlay"></div>@endif

                            <a href="{{ route('ebooks.show', $ebook->id) }}" style="display:block; width:100%; height:100%;">
                                <img src="{{ asset('storage/ebook_covers/' . $ebook->cover_image) }}" alt="{{ $ebook->title_en }}">
                            </a>

                            <span class="ebook-preview-badge"><i class="fa-solid fa-book-open-reader"></i> বইটি কিছু অংশ পড়ুন</span>

                            <div class="shop-actions">
                                <button class="shop-action-btn quick-view-btn" data-id="{{ $ebook->id }}" title="View Details"><i class="fa-regular fa-eye"></i></button>
                                @if($isInCart)
                                <button class="shop-action-btn in-cart-state" title="Already in Cart"><i class="fa-solid fa-check"></i></button>
                                @else
                                <button class="shop-action-btn addToEbookCart" data-url="{{ route('ebooks.buy', $ebook->id) }}" data-ebook="{{ $ebook->id }}" title="Add to Cart"><i class="fa-solid fa-cart-shopping"></i></button>
                                @endif
                               {{-- @if($ebook->preview_path)
                                <button class="shop-action-btn ebook-preview-btn" data-eid="{{ $ebook->id }}" title="বইটি কিছু অংশ পড়ুন"><i class="fa-solid fa-book-open-reader"></i></button>
                                @endif--}}
                                <a href="{{ route('ebooks.show', $ebook->id) }}" class="shop-action-btn" title="View Full Details"><i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <span style="font-size: 11px; color: var(--accent); font-weight: 700; text-transform: uppercase;">{{ optional($ebook->category)->name_bn ?? optional($ebook->category)->name_en }}</span>
                            <h3 style="margin-top: 5px; font-size: 15px; font-weight: 700; line-height: 1.4;">
                                <a href="{{ route('ebooks.show', $ebook->id) }}" style="text-decoration: none; color: inherit;">{{ Str::limit($ebook->title_bn ?? $ebook->title_en, 40) }}</a>
                            </h3>
                            <p style="font-size: 12px; color: var(--text-muted); margin: 4px 0 10px;"><i class="fa-solid fa-pen-nib me-1"></i> {{ $ebook->author_name ?? 'অজানা' }}</p>

                            <div style="display: flex; flex-direction: column; gap: 6px;">
                                <div class="shop-price-box" style="margin-bottom: 0; display:flex; align-items:baseline; gap:8px;">
                                    @if($ebook->is_free)
                                        <span class="price" style="font-size: 16px; font-weight: 700; color: #16a34a;">ফ্রি</span>
                                    @else
                                        <span class="price" style="font-size: 16px; font-weight: 700; color: var(--accent);">৳{{ number_format($ebook->final_price, 0) }}</span>
                                        @if($ebook->discount > 0)
                                            <span style="font-size: 13px; color: var(--text-muted); text-decoration: line-through;">৳{{ number_format($ebook->price, 0) }}</span>
                                        @endif
                                    @endif
                                </div>
                                <div style="display: flex; flex-direction: row; gap: 8px; width: 100%;">
                                    @if($isInCart)
                                    <a href="{{ route('cart') }}" class="go-to-cart-link">
                                        <i class="fa-solid fa-cart-shopping"></i> Go to Cart
                                    </a>
                                    <button class="shop-buy-btn in-cart-state" disabled>
                                        <i class="fa-solid fa-check"></i> In Cart
                                    </button>
                                    @else
                                    <button class="shop-cart-btn addToEbookCart" data-url="{{ route('ebooks.buy', $ebook->id) }}" data-ebook="{{ $ebook->id }}" title="Add to Cart">
                                        <i class="fa-solid fa-cart-plus"></i> Add To Cart
                                    </button>
                                    <a href="{{ route('ebooks.buy', $ebook->id) }}" class="shop-buy-btn" title="Buy Now" style="text-decoration: none;">
                                        <i class="fa-solid fa-bolt"></i> Buy Now
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </article>
                    @empty
                    <div style="grid-column: 1/-1; text-align: center; padding: 60px; background: var(--bg-soft); border-radius: var(--radius-lg);">
                        <i class="fa-solid fa-book-open" style="font-size: 48px; color: var(--text-muted); margin-bottom: 20px;"></i>
                        <h3 style="color: var(--text-soft);">কোনো ই-বুক পাওয়া যায়নি</h3>
                    </div>
                    @endforelse
                </div>

                <div class="mt-5">
                    {{ $ebooks->links() }}
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Quick View Modal -->
<div class="modal fade" id="ebookQuickViewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 20px 60px rgba(0,0,0,0.15); overflow: hidden;">
            <div class="modal-body p-0 position-relative" id="ebookQuickViewContent"></div>
        </div>
    </div>
</div>

<!-- Preview Modal (custom overlay — reliable) -->
<div class="ebx-modal-overlay" id="ebookPreviewModal">
    <div class="ebx-modal-box">
        <div class="ebx-modal-head">
            <h4 id="ebookPreviewHeadTitle"><i class="fa-solid fa-book-open me-2" style="color:var(--accent);"></i>প্রিভিউ</h4>
            <button class="ebx-modal-close" id="ebookPreviewClose"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="ebx-modal-body">
            <!-- PDF Viewer -->
            <div class="ebx-modal-pdf">
                <div id="ebookPreviewLoader" class="ebx-modal-loader">
                    <i class="fa-solid fa-spinner fa-spin fa-2x"></i>
                    <p style="font-size:13px;margin-top:12px;">প্রিভিউ লোড হচ্ছে...</p>
                </div>
                <iframe id="ebookPreviewFrame" class="ebx-modal-frame" src="" allowfullscreen></iframe>
            </div>
            <!-- Sidebar -->
            <div class="ebx-modal-side">
                <img id="ebookPreviewCover" src="" alt="" style="width:100%;border-radius:8px;box-shadow:0 4px 14px rgba(43,37,83,.14);">
                <span id="ebookPreviewCategory" style="font-size:10px;font-weight:700;color:var(--accent);text-transform:uppercase;letter-spacing:.5px;"></span>
                <h3 id="ebookPreviewTitle" style="font-size:14px;font-weight:800;color:var(--primary);margin:2px 0;line-height:1.3;"></h3>
                <p id="ebookPreviewAuthor" style="font-size:12px;color:var(--text-muted);margin:0;"><i class="fa-solid fa-pen-nib me-1"></i> <span></span></p>
                <div style="display:flex;align-items:baseline;gap:8px;margin-top:4px;">
                    <span id="ebookPreviewPrice" style="font-size:20px;font-weight:900;color:var(--accent);"></span>
                    <span id="ebookPreviewOriginalPrice" style="font-size:13px;color:var(--text-muted);text-decoration:line-through;"></span>
                </div>
                <p id="ebookPreviewDescription" style="font-size:12px;color:var(--text-soft);line-height:1.6;margin:6px 0 0;"></p>
                <div style="margin-top:auto;display:flex;flex-direction:column;gap:8px;padding-top:14px;">
                    <a id="ebookPreviewBuyBtn" href="#" class="ebx-btn-buy">
                        <i class="fa-solid fa-cart-shopping"></i> এখনই কিনুন
                    </a>
                    <a id="ebookPreviewDetailsBtn" href="#" class="ebx-btn-detail">
                        বিস্তারিত দেখুন <i class="fa-solid fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    $(document).ready(function() {
        // Move preview overlay to <body> so no ancestor can clip/stack it
        $('#ebookPreviewModal').appendTo('body');

        // Quick View AJAX for ebooks
        $(document).on('click', '.ebook-card .quick-view-btn', function() {
            let id = $(this).data('id');
            $('#ebookQuickViewModal').modal('show');
            $('#ebookQuickViewContent').html('<div class="p-5 text-center"><i class="fa-solid fa-spinner fa-spin fa-2x" style="color: var(--accent);"></i></div>');

            $.get("{{ route('ebooks.quick.view') }}", {id: id}, function(res) {
                $('#ebookQuickViewContent').html(res.html);
            });
        });

        // Transform ebook card to "in-cart" state after AJAX add
        function markEbookInCart(ebookId) {
            let $card = $('article.ebook-card[data-eid="' + ebookId + '"]');
            $card.addClass('in-cart-card');

            let $thumb = $card.find('.ebook-thumb');
            if (!$thumb.find('.in-cart-badge').length) {
                $thumb.prepend('<span class="in-cart-badge"><i class="fa-solid fa-check-circle"></i> In Cart</span>');
                if (!$thumb.find('.in-cart-overlay').length) {
                    $thumb.append('<div class="in-cart-overlay"></div>');
                }
            }

            // Icon buttons
            $card.find('.shop-action-btn.addToEbookCart').each(function() {
                let $btn = $(this);
                $btn.removeClass('addToEbookCart').addClass('in-cart-state')
                    .attr('title', 'Already in Cart')
                    .html('<i class="fa-solid fa-check"></i>');
            });

            // Text buttons
            $card.find('.shop-cart-btn.addToEbookCart').replaceWith(
                '<a href="{{ route('cart') }}" class="go-to-cart-link"><i class="fa-solid fa-cart-shopping"></i> Go to Cart</a>'
            );
            $card.find('.shop-buy-btn').not('.in-cart-state').replaceWith(
                '<button class="shop-buy-btn in-cart-state" disabled><i class="fa-solid fa-check"></i> In Cart</button>'
            );
        }

        // Preview Modal — open PDF in modal with sidebar tooltip
        function openEbookPreview(ebookId) {
            let $card = $('article.ebook-card[data-eid="' + ebookId + '"]');

            // Reset modal
            $('#ebookPreviewFrame').hide().attr('src', '');
            $('#ebookPreviewLoader').show();

            // Populate sidebar from card data
            let $thumbImg = $card.find('.ebook-thumb img');
            let $titleLink = $card.find('h3 a');
            let $authorText = $card.find('.card-body p').first().text().trim();
            let $price = $card.find('.price').text().trim();
            let $category = $card.find('.card-body span').first().text().trim();
            let detailsUrl = $card.find('h3 a').attr('href');
            let buyUrl = $card.find('.addToEbookCart, .go-to-cart-link').first().data('url') || $card.find('.addToEbookCart, .go-to-cart-link').first().attr('href') || '#';

            $('#ebookPreviewCover').attr('src', $thumbImg.attr('src'));
            $('#ebookPreviewTitle').text($titleLink.text().trim());
            $('#ebookPreviewAuthor span').text($authorText.replace('✍', '').trim());
            $('#ebookPreviewPrice').text($price);
            $('#ebookPreviewCategory').text($category);
            $('#ebookPreviewOriginalPrice').text('');
            $('#ebookPreviewDescription').text('');
            $('#ebookPreviewBuyBtn').attr('href', buyUrl);
            $('#ebookPreviewDetailsBtn').attr('href', detailsUrl);
            $('#ebookPreviewHeadTitle').html('<i class="fa-solid fa-book-open me-2" style="color:var(--accent);"></i>' + $titleLink.text().trim());

            // Open custom overlay
            $('#ebookPreviewModal').addClass('open');
            $('body').css('overflow', 'hidden');

            // Fetch PDF URL via AJAX
            $.get("{{ route('ebooks.preview') }}", {id: ebookId})
              .done(function(res) {
                if (res.pdf_url) {
                    $('#ebookPreviewFrame').on('load', function() {
                        $('#ebookPreviewLoader').hide();
                        $(this).show();
                    }).attr('src', res.pdf_url);
                } else {
                    $('#ebookPreviewLoader').html('<i class="fa-solid fa-book-open fa-2x" style="opacity:.5"></i><p style="font-size:13px;margin-top:12px;">এই বইয়ের প্রিভিউ পাওয়া যায়নি।</p>');
                }
              })
              .fail(function() {
                $('#ebookPreviewLoader').html('<i class="fa-solid fa-book-open fa-2x" style="opacity:.5"></i><p style="font-size:13px;margin-top:12px;">এই বইয়ের প্রিভিউ পাওয়া যায়নি।<br><span style="font-size:12px;opacity:.7">বিস্তারিত পেজে বইটি সম্পর্কে জানুন।</span></p>');
              });

            // Fetch full description via AJAX
            $.get("{{ route('ebooks.quick.view') }}", {id: ebookId}, function(res) {
                if (res.html) {
                    let $tmp = $('<div>').html(res.html);
                    let desc = $tmp.find('p').last().text().trim();
                    let origPrice = $tmp.find('span[style*="line-through"]').text().trim();
                    if (desc) $('#ebookPreviewDescription').text(desc);
                    if (origPrice) $('#ebookPreviewOriginalPrice').text(origPrice);
                }
            });
        }

        $(document).on('click', '.ebook-preview-badge', function(e) {
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();
            let ebookId = $(this).closest('.ebook-card').data('eid');
            openEbookPreview(ebookId);
            return false;
        });

        $(document).on('click', '.ebook-preview-btn', function(e) {
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();
            let ebookId = $(this).data('eid');
            openEbookPreview(ebookId);
            return false;
        });

        // Close custom preview overlay
        function closeEbookPreview() {
            $('#ebookPreviewModal').removeClass('open');
            $('body').css('overflow', '');
            $('#ebookPreviewFrame').attr('src', '').hide();
            $('#ebookPreviewLoader').show();
        }
        $('#ebookPreviewClose').on('click', closeEbookPreview);
        $('#ebookPreviewModal').on('click', function(e) {
            if (e.target === this) closeEbookPreview();
        });
        $(document).on('keydown', function(e) {
            if (e.key === 'Escape' && $('#ebookPreviewModal').hasClass('open')) closeEbookPreview();
        });
        // Close after clicking Buy/Details (they navigate away anyway)
        $('#ebookPreviewBuyBtn, #ebookPreviewDetailsBtn').on('click', function() {
            $('body').css('overflow', '');
        });

        // Add to Cart AJAX for ebooks
        $(document).on('click', '.addToEbookCart', function(e) {
            e.preventDefault();
            e.stopPropagation();
            let btn = $(this);
            let ebookId = btn.data('ebook') || btn.data('id');
            let url = btn.data('url');

            if (btn.prop('disabled')) return;

            let originalContent = btn.html();
            btn.prop('disabled', true).addClass('disabled');

            if (btn.hasClass('shop-action-btn')) {
                btn.html('<i class="fa-solid fa-spinner fa-spin"></i>');
            } else {
                btn.text('Adding...');
            }

            $.ajax({
                url: url,
                method: "GET",
                dataType: "json",
                success: function(res) {
                    if (res.login_required) {
                        showLoginToast();
                        btn.html(originalContent);
                        btn.prop('disabled', false).removeClass('disabled');
                        return;
                    }
                    if (res.status) {
                        $('.cartCount').text(parseInt($('.cartCount').text() || 0) + 1);
                        markEbookInCart(ebookId);
                        showCartNotification(res.message, 'success');
                    }
                },
                error: function(xhr) {
                    btn.html(originalContent);
                    btn.prop('disabled', false).removeClass('disabled');
                    if (xhr.status === 401) {
                        showLoginToast();
                    }
                }
            });
        });

        function showLoginToast() {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            Toast.fire({
                icon: 'warning',
                title: 'কার্টে যোগ করতে প্রথমে লগইন করুন।',
                showCloseButton: true,
            });
        }

        // Popular carousel scroll
        var track = document.getElementById('ebxPopTrack');
        if (track) {
            var step = 280;
            var prev = document.getElementById('ebxPopPrev');
            var next = document.getElementById('ebxPopNext');
            if (prev) prev.addEventListener('click', function(){ track.scrollBy({left:-step, behavior:'smooth'}); });
            if (next) next.addEventListener('click', function(){ track.scrollBy({left:step, behavior:'smooth'}); });
        }
    });
</script>
@endpush

