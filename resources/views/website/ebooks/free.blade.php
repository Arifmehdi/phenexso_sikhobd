@extends('website.layouts.sikhobd')

@section('title', 'ফ্রি ই-বুক — ' . ($ws->website_title ?? 'Qalam HR'))

@push('css')
<style>
    .febook-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; }
    @media (max-width: 991px) { .febook-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 575px) { .febook-grid { grid-template-columns: 1fr; } }

    .febook-card { background:#fff; border:1px solid var(--border); border-radius:16px; overflow:hidden; display:flex; flex-direction:column; transition: all .3s ease; }
    .febook-card:hover { transform: translateY(-6px); box-shadow: 0 16px 34px rgba(0,0,0,.10); }
    .febook-thumb { aspect-ratio: 260/372; background:#f8fafc; position:relative; overflow:hidden; }
    .febook-thumb img { width:100%; height:100%; object-fit:cover; transition: transform .35s; }
    .febook-card:hover .febook-thumb img { transform: scale(1.05); }
    .febook-free-tag { position:absolute; top:12px; left:12px; background:#16a34a; color:#fff; font-size:11px; font-weight:700; padding:4px 12px; border-radius:20px; text-transform:uppercase; letter-spacing:.5px; z-index:3; }
    .febook-body { padding:16px; display:flex; flex-direction:column; flex:1; }
    .febook-cat { font-size:11px; color:var(--accent); font-weight:700; text-transform:uppercase; }
    .febook-body h3 { margin:6px 0 4px; font-size:15px; font-weight:700; line-height:1.4; }
    .febook-body h3 a { color:inherit; text-decoration:none; }
    .febook-author { font-size:12px; color:var(--text-muted); margin:0 0 12px; }
    .febook-actions { display:flex; gap:8px; margin-top:auto; }
    .febook-btn { flex:1; height:38px; border:none; border-radius:9px; font-weight:700; font-size:13px; display:inline-flex; align-items:center; justify-content:center; gap:6px; cursor:pointer; text-decoration:none; transition: all .25s; }
    .febook-btn.read { background:var(--accent); color:#fff; }
    .febook-btn.read:hover { background:var(--primary); color:#fff; }
    .febook-btn.dl { background:#16a34a; color:#fff; }
    .febook-btn.dl:hover { background:#15803d; color:#fff; }
</style>
@endpush

@section('content')
<section class="section" style="padding: 60px 0; background:#f8fafc;">
    <div class="container">
        <div class="section-header mb-5 text-center">
            <h2 style="font-weight:800; color:#1e293b;">
                <i class="fa-solid fa-gift" style="color:#16a34a;"></i> ফ্রি ই-বুক
            </h2>
            <p class="text-muted">বিনামূল্যে ডাউনলোড ও পড়ুন</p>
        </div>

        <div class="row">
            <div class="col-lg-3">
                <div class="card border-0 shadow-sm mb-4" style="border-radius:15px;">
                    <div class="card-body">
                        <h5 style="font-weight:700; margin-bottom:20px;">ক্যাটেগরি</h5>
                        <ul class="list-unstyled mb-0">
                            <li>
                                <a href="{{ route('free.ebooks') }}" class="d-flex py-2 {{ !request('category') ? 'text-primary font-weight-bold' : 'text-muted' }}">সব ফ্রি ই-বুক</a>
                            </li>
                            @foreach($categories as $category)
                            <li>
                                <a href="{{ route('free.ebooks', ['category' => $category->id]) }}" class="d-flex py-2 {{ request('category') == $category->id ? 'text-primary font-weight-bold' : 'text-muted' }}">
                                    {{ $category->name_bn ?? $category->name_en }}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-9">
                <div class="febook-grid">
                    @forelse($ebooks as $ebook)
                    <article class="febook-card">
                        <div class="febook-thumb">
                            <span class="febook-free-tag"><i class="fa-solid fa-gift"></i> Free</span>
                            <a href="{{ route('ebooks.read', $ebook->id) }}" style="display:block; width:100%; height:100%;">
                                <img src="{{ asset('storage/ebook_covers/' . $ebook->cover_image) }}" alt="{{ $ebook->title_en }}">
                            </a>
                        </div>
                        <div class="febook-body">
                            <span class="febook-cat">{{ optional($ebook->category)->name_bn ?? optional($ebook->category)->name_en }}</span>
                            <h3><a href="{{ route('ebooks.read', $ebook->id) }}">{{ Str::limit($ebook->title_bn ?? $ebook->title_en, 42) }}</a></h3>
                            <p class="febook-author"><i class="fa-solid fa-pen-nib me-1"></i> {{ $ebook->author_name ?? 'অজানা' }}</p>
                            <div class="febook-actions">
                                <a href="{{ route('ebooks.read', $ebook->id) }}" class="febook-btn read"><i class="fa-solid fa-book-open"></i> পড়ুন</a>
                                <a href="{{ route('ebooks.download', $ebook->id) }}" class="febook-btn dl"><i class="fa-solid fa-download"></i> ডাউনলোড</a>
                            </div>
                        </div>
                    </article>
                    @empty
                    <div style="grid-column:1/-1; text-align:center; padding:60px; background:#fff; border-radius:16px;">
                        <i class="fa-solid fa-gift" style="font-size:48px; color:#cbd5e1; margin-bottom:20px;"></i>
                        <h3 style="color:#64748b;">কোনো ফ্রি ই-বুক পাওয়া যায়নি</h3>
                    </div>
                    @endforelse
                </div>
                <div class="mt-5">{{ $ebooks->links() }}</div>
            </div>
        </div>
    </div>
</section>
@endsection
