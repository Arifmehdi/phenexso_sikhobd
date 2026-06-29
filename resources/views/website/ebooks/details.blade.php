@extends('website.layouts.sikhobd')
@section('title', ($ebook->title_bn ?? $ebook->title_en) . ' — ' . ($ws->website_title ?? 'Qalam HR'))

@push('css')
<style>
/* ══════════════════════════════════════════════
   EBOOK DETAIL — Rokomari-style, theme colors
══════════════════════════════════════════════ */
.ebd-page { background: var(--bg-soft); padding: 24px 0 60px; }

/* Breadcrumb */
.ebd-crumbs { display:flex; flex-wrap:wrap; gap:6px; align-items:center; font-size:13px; color:var(--text-muted); margin-bottom:16px; }
.ebd-crumbs a { color:var(--text-muted); text-decoration:none; }
.ebd-crumbs a:hover { color:var(--accent); }
.ebd-crumbs i { font-size:9px; }
.ebd-crumbs span { color:var(--primary); font-weight:600; }

/* White panel */
.ebd-panel { background:#fff; border:1px solid var(--border); border-radius:var(--radius-lg); }

/* ── Hero grid ─────────────────────────────── */
.ebd-hero-grid {
    display:grid;
    grid-template-columns: 320px 1fr 290px;
    gap:0;
}
.ebd-hero-col { padding:32px; }
.ebd-hero-col + .ebd-hero-col { border-left:1px solid var(--border); }
@media(max-width:991px){
    .ebd-hero-grid { grid-template-columns:280px 1fr; }
    .ebd-hero-side { grid-column:1/-1; border-left:none !important; border-top:1px solid var(--border); }
}
@media(max-width:575px){
    .ebd-hero-grid { grid-template-columns:1fr; }
    .ebd-hero-col + .ebd-hero-col { border-left:none; border-top:1px solid var(--border); }
}

/* ── Cover (3-D fold) ──────────────────────── */
.eb-scene { perspective:1400px; width:230px; margin:0 auto; }
.eb-book {
    position:relative; width:100%;
    transform-style:preserve-3d; transform:none;
    transition:transform .55s cubic-bezier(.4,0,.2,1), filter .55s ease;
    filter:drop-shadow(0 10px 24px rgba(43,37,83,.22));
    cursor:pointer;
}
.eb-book:hover { transform:rotateY(-24deg) rotateX(4deg); filter:drop-shadow(8px 18px 30px rgba(43,37,83,.34)); }
.eb-pages {
    position:absolute; top:3px; bottom:3px; right:-10px; width:10px;
    background:linear-gradient(to right,#c5bbad,#f3eee5 50%,#e8e2d6);
    border-radius:0 2px 2px 0; overflow:hidden;
    transform:rotateY(90deg) translateZ(5px);
    opacity:0; transition:opacity .45s ease .1s, width .5s ease;
}
.eb-book:hover .eb-pages { opacity:1; width:14px; right:-14px; }
.eb-pages::before { content:''; position:absolute; inset:0;
    background:repeating-linear-gradient(to bottom,transparent 0,transparent 4px,rgba(0,0,0,.06) 4px,rgba(0,0,0,.06) 5px); }
.eb-spine {
    position:absolute; top:0; bottom:0; left:-8px; width:8px;
    background:linear-gradient(to right,var(--primary-dark,#1d1839),var(--primary,#2b2553));
    border-radius:2px 0 0 2px;
    transform:rotateY(-90deg) translateZ(4px);
    opacity:0; transition:opacity .45s ease .1s;
}
.eb-book:hover .eb-spine { opacity:1; }
.eb-front {
    position:relative; width:100%; border-radius:6px; overflow:hidden;
    transform:translateZ(5px); transition:border-radius .45s ease;
    box-shadow:inset -2px 0 6px rgba(0,0,0,.1);
}
.eb-book:hover .eb-front { border-radius:2px 6px 6px 2px; }
.eb-front img { width:100%; display:block; }
.eb-no-cover {
    width:100%; aspect-ratio:3/4;
    background:linear-gradient(135deg,var(--primary),#4a4180);
    display:flex; align-items:center; justify-content:center;
    font-size:44px; color:rgba(255,255,255,.3);
}
.eb-peel {
    position:absolute; left:0; right:0; top:0; height:0;
    transform-origin:top center; pointer-events:none; z-index:10; opacity:0; overflow:hidden;
    transition:height .4s ease, transform .4s ease, opacity .4s ease;
}
.eb-book:hover .eb-peel { height:38%; transform:rotateX(-10deg); opacity:1; }
.eb-peel::before { content:''; position:absolute; inset:0;
    background:linear-gradient(to bottom,rgba(255,252,248,.9) 0%,rgba(248,244,236,.6) 55%,transparent 100%);
    border-radius:6px 6px 0 0; }

.eb-disc {
    position:absolute; top:-14px; left:-14px;
    width:60px; height:60px; border-radius:50%;
    background:var(--accent); color:#fff;
    display:flex; flex-direction:column; align-items:center; justify-content:center;
    font-weight:800; font-size:15px; line-height:1.05; z-index:20;
    box-shadow:0 4px 14px rgba(255,40,79,.42);
}
.eb-disc small { font-size:9px; font-weight:600; letter-spacing:.5px; }

.eb-hint {
    text-align:center; margin-top:20px;
    font-size:14px; font-weight:700; color:var(--accent); cursor:pointer; user-select:none;
}
.eb-hint i { margin-left:3px; display:inline-block; animation:hintB 1.3s ease infinite; }
@keyframes hintB { 0%,100%{transform:translateY(0)} 55%{transform:translateY(4px)} }

/* ── Middle info ───────────────────────────── */
.ebd-title { font-size:26px; font-weight:800; color:var(--primary); line-height:1.3; margin-bottom:12px; }
.ebd-byline { font-size:14px; color:var(--text-soft); margin-bottom:6px; }
.ebd-byline a { color:var(--accent); text-decoration:none; font-weight:600; }
.ebd-byline a:hover { text-decoration:underline; }
.ebd-byline .lbl { color:var(--text-muted); }

.ebd-rating { display:flex; align-items:center; gap:8px; margin:12px 0 18px; }
.ebd-stars { color:#fbbf24; font-size:14px; letter-spacing:1px; }
.ebd-rating-text { font-size:13px; color:var(--text-muted); }

/* Price block */
.ebd-price { display:flex; align-items:baseline; flex-wrap:wrap; gap:10px; margin-bottom:4px; }
.ebd-price-now { font-size:30px; font-weight:800; color:var(--accent); line-height:1; }
.ebd-price-was { font-size:17px; color:var(--text-muted); text-decoration:line-through; }
.ebd-price-off { font-size:13px; font-weight:700; color:#16a34a; }
.ebd-price-note { font-size:12px; color:var(--text-muted); margin-bottom:20px; }

/* Action buttons */
.ebd-actions { display:flex; flex-wrap:wrap; gap:10px; margin-bottom:20px; }
.ebd-btn-primary {
    display:inline-flex; align-items:center; gap:8px;
    padding:12px 28px; background:var(--primary); color:#fff; border:none;
    border-radius:var(--radius-full); font-size:14px; font-weight:700;
    cursor:pointer; text-decoration:none; transition:background .2s, transform .15s;
}
.ebd-btn-primary:hover { background:var(--primary-dark,#1d1839); transform:translateY(-1px); color:#fff; }
.ebd-btn-primary:disabled { opacity:.7; cursor:not-allowed; transform:none; }
.ebd-btn-primary.green { background:#16a34a; }
.ebd-btn-primary.green:hover { background:#15803d; }
.ebd-btn-accent { background:var(--accent); }
.ebd-btn-accent:hover { background:var(--accent-light,#ff6b85); }
.ebd-btn-outline {
    display:inline-flex; align-items:center; gap:8px;
    padding:12px 24px; background:#fff; color:var(--primary);
    border:1.5px solid var(--border); border-radius:var(--radius-full);
    font-size:14px; font-weight:700; cursor:pointer; transition:border-color .2s, background .2s;
}
.ebd-btn-outline:hover { border-color:var(--primary); background:var(--bg-muted); }

/* Delivery info chips */
.ebd-deliv { display:flex; flex-direction:column; gap:10px; padding-top:18px; border-top:1px dashed var(--border); }
.ebd-deliv-item { display:flex; align-items:center; gap:10px; font-size:13px; color:var(--text-soft); }
.ebd-deliv-item i { width:18px; text-align:center; color:var(--accent); }

/* ── Sidebar related list ──────────────────── */
.ebd-side-title { font-size:14px; font-weight:800; color:var(--primary); margin-bottom:16px; padding-bottom:10px; border-bottom:2px solid var(--bg-muted); }
.ebd-side-item { display:flex; gap:12px; padding:10px 0; border-bottom:1px solid var(--border); text-decoration:none; }
.ebd-side-item:last-child { border-bottom:none; }
.ebd-side-thumb { width:48px; height:64px; border-radius:4px; object-fit:cover; flex-shrink:0; background:var(--bg-muted); }
.ebd-side-thumb-ph { width:48px; height:64px; border-radius:4px; flex-shrink:0;
    background:linear-gradient(135deg,var(--primary),#4a4180); display:flex; align-items:center; justify-content:center; color:rgba(255,255,255,.4); }
.ebd-side-name { font-size:12.5px; font-weight:600; color:var(--primary); line-height:1.35;
    display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }
.ebd-side-item:hover .ebd-side-name { color:var(--accent); }
.ebd-side-author { font-size:11px; color:var(--text-muted); margin-top:2px; }
.ebd-side-price { font-size:13px; font-weight:700; color:var(--accent); margin-top:4px; }
.ebd-side-price del { font-size:11px; color:var(--text-muted); font-weight:400; margin-left:4px; }

/* ── Section blocks ────────────────────────── */
.ebd-block { margin-top:24px; }
.ebd-block-head {
    display:flex; align-items:center; gap:10px;
    padding:14px 22px; background:var(--bg-muted);
    border:1px solid var(--border); border-bottom:none;
    border-radius:var(--radius-lg) var(--radius-lg) 0 0;
}
.ebd-block-head i { color:var(--accent); }
.ebd-block-head h3 { margin:0; font-size:16px; font-weight:800; color:var(--primary); }
.ebd-block-body {
    padding:22px; background:#fff;
    border:1px solid var(--border); border-radius:0 0 var(--radius-lg) var(--radius-lg);
}
.ebd-desc { color:var(--text-soft); font-size:14.5px; line-height:1.9; }

/* Specs table */
.ebd-specs { display:grid; grid-template-columns:1fr 1fr; gap:0; }
@media(max-width:575px){ .ebd-specs{grid-template-columns:1fr;} }
.ebd-spec { display:flex; gap:10px; padding:11px 0; border-bottom:1px solid var(--border); font-size:13.5px; }
.ebd-spec:nth-child(odd) { padding-right:20px; }
.ebd-spec .k { color:var(--text-muted); min-width:90px; font-weight:600; }
.ebd-spec .v { color:var(--primary); font-weight:600; }

/* ── Related grid ──────────────────────────── */
.ebd-grid-head { display:flex; align-items:center; justify-content:space-between; margin:28px 0 18px; }
.ebd-grid-head h2 { margin:0; font-size:20px; font-weight:800; color:var(--primary); }
.ebd-grid-head a { font-size:13px; font-weight:600; color:var(--accent); text-decoration:none; }
.ebd-grid-head a:hover { text-decoration:underline; }

.ebd-grid { display:grid; grid-template-columns:repeat(5,1fr); gap:18px; }
@media(max-width:1100px){ .ebd-grid{grid-template-columns:repeat(4,1fr);} }
@media(max-width:850px){ .ebd-grid{grid-template-columns:repeat(3,1fr);} }
@media(max-width:560px){ .ebd-grid{grid-template-columns:repeat(2,1fr); gap:12px;} }

.ebd-card {
    background:#fff; border:1px solid var(--border); border-radius:var(--radius-lg);
    overflow:hidden; display:flex; flex-direction:column;
    transition:transform .22s ease, box-shadow .22s ease;
}
.ebd-card:hover { transform:translateY(-4px); box-shadow:var(--shadow-md,0 10px 26px rgba(43,37,83,.1)); }
.ebd-card-thumb { aspect-ratio:260/360; position:relative; background:var(--bg-muted); overflow:hidden; }
.ebd-card-thumb img { width:100%; height:100%; object-fit:cover; transition:transform .35s ease; }
.ebd-card:hover .ebd-card-thumb img { transform:scale(1.05); }
.ebd-card-thumb .ph { width:100%; height:100%; display:flex; align-items:center; justify-content:center; font-size:32px; color:var(--primary); opacity:.25; }
.ebd-card-badge { position:absolute; top:8px; left:8px; color:#fff; font-size:10px; font-weight:700; padding:3px 8px; border-radius:var(--radius-full); }
.ebd-card-badge.disc { background:var(--accent); }
.ebd-card-badge.free { background:#16a34a; }
.ebd-card-body { padding:11px 12px 13px; flex:1; display:flex; flex-direction:column; }
.ebd-card-title { font-size:13px; font-weight:700; color:var(--primary); line-height:1.35; margin-bottom:3px;
    display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }
.ebd-card-title a { color:inherit; text-decoration:none; }
.ebd-card-title a:hover { color:var(--accent); }
.ebd-card-author { font-size:11px; color:var(--text-muted); margin-bottom:8px; }
.ebd-card-foot { margin-top:auto; display:flex; align-items:center; justify-content:space-between; }
.ebd-card-price { font-size:15px; font-weight:800; color:var(--accent); }
.ebd-card-price del { font-size:11px; color:var(--text-muted); font-weight:400; margin-left:4px; }
.ebd-card-cart { width:30px; height:30px; border-radius:50%; background:var(--bg-muted); color:var(--primary);
    border:none; display:flex; align-items:center; justify-content:center; font-size:12px; cursor:pointer; text-decoration:none;
    transition:background .2s, color .2s; }
.ebd-card-cart:hover { background:var(--accent); color:#fff; }

/* ── Best seller badge + ratings line ──────── */
.ebd-bestseller {
    display:inline-flex; align-items:center; gap:5px;
    background:#fff7ed; color:#c2410c; border:1px solid #fed7aa;
    font-size:12px; font-weight:700; padding:3px 10px; border-radius:6px;
}
.ebd-subject-link { font-size:13px; color:var(--accent); text-decoration:none; font-weight:600; }
.ebd-subject-link:hover { text-decoration:underline; }
.ebd-ratings-line { display:flex; align-items:center; gap:10px; margin:14px 0; font-size:13px; color:var(--text-soft); flex-wrap:wrap; }
.ebd-ratings-line .stars { color:#fbbf24; font-size:15px; letter-spacing:1px; }
.ebd-ratings-line .div { color:var(--border); }
.ebd-fav-line { display:flex; align-items:center; gap:8px; font-size:13px; color:var(--text-soft); margin-bottom:16px; }
.ebd-fav-line i { color:var(--text-muted); }

/* Format toggle (Hard Copy / eBook) */
.ebd-formats { display:flex; gap:12px; margin:6px 0 18px; }
.ebd-format {
    flex:0 0 auto; min-width:130px;
    border:1.5px solid var(--border); border-radius:10px;
    padding:10px 16px; cursor:default; background:#fff;
}
.ebd-format.active { border-color:var(--accent); background:rgba(255,40,79,.04); }
.ebd-format .ft-name { font-size:12px; color:var(--text-muted); font-weight:600; margin-bottom:2px; }
.ebd-format .ft-price { font-size:15px; font-weight:800; color:var(--primary); }
.ebd-format .ft-price del { font-size:12px; color:var(--text-muted); font-weight:400; margin-right:4px; }
.ebd-format.active .ft-price { color:var(--accent); }

/* Stock line */
.ebd-stock { display:flex; align-items:center; gap:8px; font-size:13px; color:#16a34a; font-weight:600; margin-top:14px; }

/* ── Tabs ──────────────────────────────────── */
.ebd-tabs-wrap { margin-top:24px; }
.ebd-tabs-title { font-size:18px; font-weight:800; color:var(--primary); margin-bottom:14px; }
.ebd-tabs {
    display:flex; gap:4px; border-bottom:1px solid var(--border);
}
.ebd-tab {
    padding:11px 22px; font-size:14px; font-weight:600; color:var(--text-soft);
    background:none; border:none; cursor:pointer; position:relative;
    border-bottom:2px solid transparent; margin-bottom:-1px;
}
.ebd-tab:hover { color:var(--primary); }
.ebd-tab.active { color:#16a34a; border-bottom-color:#16a34a; }
.ebd-tab-panel { display:none; padding:24px 4px; background:#fff;
    border:1px solid var(--border); border-top:none; border-radius:0 0 var(--radius-lg) var(--radius-lg); padding:24px; }
.ebd-tab-panel.active { display:block; }

/* Spec table (Rokomari style) */
.ebd-spectbl { width:100%; border-collapse:collapse; }
.ebd-spectbl tr { border-bottom:1px solid var(--border); }
.ebd-spectbl tr:last-child { border-bottom:none; }
.ebd-spectbl td { padding:12px 14px; font-size:13.5px; vertical-align:top; }
.ebd-spectbl td.k { width:160px; color:var(--text-muted); font-weight:600; background:var(--bg-soft); }
.ebd-spectbl td.v { color:var(--primary); font-weight:600; }
.ebd-spectbl td.v a { color:var(--accent); text-decoration:none; }

/* Author tab */
.ebd-author-box { display:flex; gap:20px; align-items:flex-start; }
.ebd-author-avatar { width:90px; height:90px; border-radius:50%; flex-shrink:0; object-fit:cover;
    background:linear-gradient(135deg,var(--primary),var(--accent)); display:flex; align-items:center; justify-content:center; color:#fff; font-size:32px; font-weight:700; }
.ebd-author-name { font-size:18px; font-weight:800; color:var(--primary); margin-bottom:6px; }
.ebd-author-meta { font-size:13px; color:var(--text-muted); }

/* ── Reviews & Ratings ─────────────────────── */
.ebd-reviews { margin-top:28px; background:#fff; border:1px solid var(--border); border-radius:var(--radius-lg); padding:26px; }
.ebd-reviews-head { display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px; margin-bottom:24px; }
.ebd-reviews-head h2 { margin:0; font-size:20px; font-weight:800; color:var(--primary); }
.ebd-review-login { display:flex; align-items:center; gap:12px; font-size:13px; color:var(--text-muted); }
.ebd-review-login a { padding:8px 22px; border:1.5px solid var(--accent); color:var(--accent); border-radius:var(--radius-full); font-weight:700; text-decoration:none; font-size:13px; }
.ebd-review-login a:hover { background:var(--accent); color:#fff; }

.ebd-rate-summary { display:grid; grid-template-columns:auto 1fr; gap:32px; align-items:center; }
@media(max-width:575px){ .ebd-rate-summary{grid-template-columns:1fr;gap:16px;} }
.ebd-rate-big { text-align:center; }
.ebd-rate-num { font-size:44px; font-weight:800; color:var(--primary); line-height:1; }
.ebd-rate-stars { color:#fbbf24; font-size:18px; letter-spacing:2px; margin:8px 0 4px; }
.ebd-rate-count { font-size:12px; color:var(--text-muted); }
.ebd-rate-bars { display:flex; flex-direction:column; gap:7px; }
.ebd-rate-bar { display:flex; align-items:center; gap:10px; font-size:12px; color:var(--text-muted); }
.ebd-rate-bar .lbl { min-width:46px; display:flex; align-items:center; gap:3px; }
.ebd-rate-bar .track { flex:1; height:8px; background:var(--bg-muted); border-radius:4px; overflow:hidden; }
.ebd-rate-bar .fill { height:100%; background:#fbbf24; border-radius:4px; }
.ebd-rate-bar .cnt { min-width:28px; text-align:right; }

.ebd-no-reviews { text-align:center; padding:36px 20px; color:var(--text-muted); }
.ebd-no-reviews i { font-size:40px; color:var(--border); margin-bottom:14px; }

/* ── Preview modal ─────────────────────────── */
.eb-modal-overlay { display:none; position:fixed; inset:0; background:rgba(29,24,57,.72); backdrop-filter:blur(8px);
    z-index:5000; align-items:center; justify-content:center; padding:20px; }
.eb-modal-overlay.open { display:flex; }
.eb-modal-box { background:#fff; border-radius:var(--radius-lg); overflow:hidden; width:100%; max-width:860px; max-height:90vh;
    display:flex; flex-direction:column; box-shadow:0 32px 80px rgba(43,37,83,.3); }
.eb-modal-head { display:flex; align-items:center; justify-content:space-between; padding:15px 20px;
    border-bottom:1px solid var(--border); background:var(--bg-muted); flex-shrink:0; }
.eb-modal-head h4 { margin:0; font-size:15px; font-weight:700; color:var(--primary); }
.eb-modal-close { width:32px; height:32px; background:#fff; border:1px solid var(--border); border-radius:50%; cursor:pointer;
    display:flex; align-items:center; justify-content:center; font-size:13px; color:var(--text-muted); transition:background .2s; }
.eb-modal-close:hover { background:var(--accent); color:#fff; border-color:var(--accent); }
.eb-modal-body { display:flex; flex:1; overflow:hidden; min-height:420px; }
.eb-modal-pdf { flex:1; background:#1e293b; position:relative; }
.eb-modal-loader { position:absolute; top:50%; left:50%; transform:translate(-50%,-50%); text-align:center; color:#fff; }
.eb-modal-frame { width:100%; height:100%; border:none; display:none; }
.eb-modal-side { width:200px; flex-shrink:0; background:var(--bg-soft); border-left:1px solid var(--border); padding:18px;
    display:flex; flex-direction:column; gap:12px; overflow-y:auto; }
.eb-modal-side img { width:100%; border-radius:8px; box-shadow:0 4px 14px rgba(43,37,83,.14); }
@media(max-width:768px){ .eb-modal-side{display:none;} }
</style>
@endpush

@section('content')
@php
    $discPct = ($ebook->discount > 0 && $ebook->price > 0) ? round(($ebook->discount/$ebook->price)*100) : 0;
@endphp

<div class="ebd-page">
  <div class="container">

    {{-- Breadcrumb --}}
    <div class="ebd-crumbs">
      <a href="{{ route('home') }}">হোম</a>
      <i class="fa-solid fa-chevron-right"></i>
      <a href="{{ route('ebooks.index') }}">ই-বুক</a>
      <i class="fa-solid fa-chevron-right"></i>
      <span>{{ Str::limit($ebook->title_bn ?? $ebook->title_en, 34) }}</span>
    </div>

    {{-- ═══ HERO PANEL ═══ --}}
    <div class="ebd-panel">
      <div class="ebd-hero-grid">

        {{-- Col 1: Cover --}}
        <div class="ebd-hero-col">
          <div class="eb-scene">
            <div class="eb-book ebook-preview-trigger" data-eid="{{ $ebook->id }}">
              @if($discPct > 0)
                <div class="eb-disc"><span>{{ $discPct }}%</span><small>OFF</small></div>
              @endif
              <div class="eb-spine"></div>
              <div class="eb-pages"></div>
              <div class="eb-front">
                <div class="eb-peel"></div>
                @if($ebook->cover_image)
                  <img src="{{ asset('storage/ebook_covers/'.$ebook->cover_image) }}" alt="{{ $ebook->title_en }}">
                @else
                  <div class="eb-no-cover"><i class="fa-solid fa-book-open"></i></div>
                @endif
              </div>
            </div>
          </div>
          <div class="eb-hint ebook-preview-trigger" data-eid="{{ $ebook->id }}">
            একটু পড়ে দেখুন <i class="fa-solid fa-arrow-down"></i>
          </div>
        </div>

        {{-- Col 2: Info --}}
        <div class="ebd-hero-col">
          <h1 class="ebd-title">{{ $ebook->title_bn ?? $ebook->title_en }}</h1>

          {{-- by author --}}
          <p class="ebd-byline">
            <span class="lbl">লেখক</span> <a href="#">{{ $ebook->author_name ?? 'অজানা' }}</a>
          </p>

          {{-- Best seller + subject --}}
          @if($ebook->category)
          <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;margin:10px 0;">
            <span class="ebd-bestseller"><i class="fa-solid fa-fire"></i> বেস্ট সেলার</span>
            <span style="font-size:13px;color:var(--text-muted);">বিষয়:</span>
            <a href="{{ route('ebooks.index') }}" class="ebd-subject-link">{{ $ebook->category->name_bn ?? $ebook->category->name_en }}</a>
          </div>
          @endif

          {{-- Ratings line --}}
          <div class="ebd-ratings-line">
            <span class="stars">★★★★<span style="color:#d1d5db;">★</span></span>
            <span class="div">|</span>
            <span><i class="fa-solid fa-users" style="color:var(--text-muted);"></i> {{ number_format($ebook->view_count ?? 0) }} জন পড়েছেন</span>
          </div>

          {{-- Price --}}
          <div class="ebd-price">
            @if($ebook->isFree())
              <span class="ebd-price-now" style="color:#16a34a;">ফ্রি</span>
            @else
              <span class="ebd-price-now">৳{{ number_format($ebook->final_price,0) }}</span>
              @if($discPct > 0)
                <span class="ebd-price-was">৳{{ number_format($ebook->price,0) }}</span>
                <span class="ebd-price-off">{{ $discPct }}% ছাড়</span>
              @endif
            @endif
          </div>
          <p class="ebd-price-note">একবার কিনুন, আজীবন পড়ুন (PDF ই-বুক)</p>

          {{-- Format toggle --}}
          @if(!$ebook->isFree())
          <div class="ebd-formats">
            <div class="ebd-format active">
              <div class="ft-name"><i class="fa-solid fa-tablet-screen-button me-1"></i> ই-বুক</div>
              <div class="ft-price">
                @if($discPct > 0)<del>৳{{ number_format($ebook->price,0) }}</del>@endif
                ৳{{ number_format($ebook->final_price,0) }}
              </div>
            </div>
          </div>
          @endif

          {{-- Buttons --}}
          <div class="ebd-actions">
            @if($ebook->isFree())
              <a href="{{ route('ebooks.read', $ebook->id) }}" class="ebd-btn-primary green">
                <i class="fa-solid fa-book-reader"></i> এখনই পড়ুন
              </a>
            @elseif($isEnrolled)
              <a href="{{ route('ebooks.read', $ebook->id) }}" class="ebd-btn-primary green">
                <i class="fa-solid fa-book-reader"></i> সম্পূর্ণ বইটি পড়ুন
              </a>
            @else
              <button id="ebookBuyBtn" type="button" data-url="{{ route('ebooks.buy', $ebook->id) }}" class="ebd-btn-primary ebd-btn-accent">
                <i class="fa-solid fa-cart-shopping"></i> এখনই কিনুন
              </button>
            @endif
            <button type="button" class="ebd-btn-outline ebook-preview-trigger" data-eid="{{ $ebook->id }}">
              <i class="fa-solid fa-book-open"></i> কিছু অংশ পড়ুন
            </button>
          </div>

          {{-- Stock --}}
          <div class="ebd-stock">
            <i class="fa-solid fa-circle-check"></i> স্টকে আছে — সাথে সাথে ডেলিভারি
          </div>

          {{-- Short description with see more --}}
          @if($ebook->description_bn || $ebook->description_en)
          <p style="font-size:13.5px;color:var(--text-soft);line-height:1.8;margin-top:16px;padding-top:16px;border-top:1px dashed var(--border);">
            {{ Str::limit(strip_tags($ebook->description_bn ?? $ebook->description_en), 180) }}
            <a href="#ebd-tabs" onclick="document.querySelector('[data-tab=summary]').click()" style="color:var(--accent);text-decoration:none;font-weight:600;">আরো পড়ুন</a>
          </p>
          @endif
        </div>

        {{-- Col 3: Sidebar related --}}
        <div class="ebd-hero-col ebd-hero-side">
          <div class="ebd-side-title">একই ধরনের বই</div>
          @forelse($sidebarEbooks as $s)
          @php $sDisc = ($s->discount>0 && $s->price>0) ? round($s->discount/$s->price*100) : 0; @endphp
          <a href="{{ route('ebooks.show', $s->id) }}" class="ebd-side-item">
            @if($s->cover_image)
              <img src="{{ asset('storage/ebook_covers/'.$s->cover_image) }}" class="ebd-side-thumb" alt="">
            @else
              <div class="ebd-side-thumb-ph"><i class="fa-solid fa-book"></i></div>
            @endif
            <div>
              <div class="ebd-side-name">{{ $s->title_bn ?? $s->title_en }}</div>
              <div class="ebd-side-author">{{ $s->author_name ?? '—' }}</div>
              <div class="ebd-side-price">
                @if($s->is_free) <span style="color:#16a34a;">ফ্রি</span>
                @else ৳{{ number_format($s->final_price,0) }}
                  @if($sDisc>0) <del>৳{{ number_format($s->price,0) }}</del> @endif
                @endif
              </div>
            </div>
          </a>
          @empty
          <p style="font-size:13px;color:var(--text-muted);">কোনো বই নেই।</p>
          @endforelse
        </div>

      </div>
    </div>

    {{-- ═══ TABS: Summary | Specification | Author ═══ --}}
    <div class="ebd-tabs-wrap" id="ebd-tabs">
      <div class="ebd-tabs-title">বইটির বিস্তারিত দেখুন</div>
      <div class="ebd-tabs">
        <button class="ebd-tab active" data-tab="summary">Summary</button>
        <button class="ebd-tab" data-tab="spec">Specification</button>
        <button class="ebd-tab" data-tab="author">Author</button>
      </div>

      {{-- Summary --}}
      <div class="ebd-tab-panel active" id="tab-summary">
        @if($ebook->description_bn || $ebook->description_en)
          <div class="ebd-desc">{!! nl2br(e($ebook->description_bn ?? $ebook->description_en)) !!}</div>
        @else
          <p style="color:var(--text-muted);">কোনো বিবরণ পাওয়া যায়নি।</p>
        @endif
      </div>

      {{-- Specification --}}
      <div class="ebd-tab-panel" id="tab-spec">
        <table class="ebd-spectbl">
          <tr><td class="k">শিরোনাম (Title)</td><td class="v">{{ $ebook->title_bn ?? $ebook->title_en }}</td></tr>
          <tr><td class="k">লেখক (Author)</td><td class="v"><a href="#">{{ $ebook->author_name ?? 'অজানা' }}</a></td></tr>
          <tr><td class="k">বিষয় (Subject)</td><td class="v"><a href="{{ route('ebooks.index') }}">{{ optional($ebook->category)->name_bn ?? optional($ebook->category)->name_en ?? 'সাধারণ' }}</a></td></tr>
          <tr><td class="k">ফরম্যাট (Format)</td><td class="v">PDF (ডিজিটাল ই-বুক)</td></tr>
          @if($ebook->preview_pages)
          <tr><td class="k">ফ্রি প্রিভিউ</td><td class="v">{{ $ebook->preview_pages }} পৃষ্ঠা</td></tr>
          @endif
          <tr><td class="k">দেশ (Country)</td><td class="v">বাংলাদেশ</td></tr>
          <tr><td class="k">ভাষা (Language)</td><td class="v">বাংলা</td></tr>
          <tr><td class="k">মূল্য (Price)</td><td class="v">@if($ebook->isFree())ফ্রি @else ৳{{ number_format($ebook->final_price,0) }}@endif</td></tr>
        </table>
      </div>

      {{-- Author --}}
      <div class="ebd-tab-panel" id="tab-author">
        <div class="ebd-author-box">
          <div class="ebd-author-avatar">{{ strtoupper(mb_substr($ebook->author_name ?? 'A', 0, 1)) }}</div>
          <div>
            <div class="ebd-author-name">{{ $ebook->author_name ?? 'অজানা লেখক' }}</div>
            <div class="ebd-author-meta">
              <i class="fa-solid fa-book me-1"></i>
              এই লেখকের বই {{ $ebook->category ? ($ebook->category->name_bn ?? $ebook->category->name_en) : '' }} বিভাগে পাওয়া যায়।
            </div>
            <a href="{{ route('ebooks.index') }}" style="display:inline-flex;margin-top:14px;padding:8px 20px;background:var(--primary);color:#fff;border-radius:var(--radius-full);font-size:13px;font-weight:700;text-decoration:none;">
              <i class="fa-solid fa-book-open me-2"></i> এই লেখকের আরো বই
            </a>
          </div>
        </div>
      </div>
    </div>

    {{-- ═══ REVIEWS & RATINGS ═══ --}}
    <div class="ebd-reviews">
      <div class="ebd-reviews-head">
        <h2>রিভিউ ও রেটিং</h2>
        <div class="ebd-review-login">
          <span>রিভিউ লিখতে লগইন করুন</span>
          @guest
            <a href="{{ route('login') }}">লগইন</a>
          @else
            <a href="#" onclick="return false;">রিভিউ দিন</a>
          @endguest
        </div>
      </div>

      <div class="ebd-rate-summary">
        <div class="ebd-rate-big">
          <div class="ebd-rate-num">0.0</div>
          <div class="ebd-rate-stars">☆☆☆☆☆</div>
          <div class="ebd-rate-count">0 রেটিং, 0 রিভিউ</div>
        </div>
        <div class="ebd-rate-bars">
          @foreach([5,4,3,2,1] as $star)
          <div class="ebd-rate-bar">
            <span class="lbl">{{ $star }} <i class="fa-solid fa-star" style="color:#fbbf24;font-size:10px;"></i></span>
            <span class="track"><span class="fill" style="width:0%;"></span></span>
            <span class="cnt">0</span>
          </div>
          @endforeach
        </div>
      </div>

      <div class="ebd-no-reviews">
        <i class="fa-regular fa-comment-dots"></i>
        <p style="margin:0;font-weight:600;">এই বইয়ের জন্য এখনো কোনো রিভিউ নেই।</p>
        <p style="margin:6px 0 0;font-size:13px;">প্রথম রিভিউটি আপনিই দিন!</p>
      </div>
    </div>

    {{-- ═══ RELATED GRID ═══ --}}
    @if($gridEbooks->count() > 0)
    <div class="ebd-grid-head">
      <h2>একই বিষয়ের আরো বই</h2>
      <a href="{{ route('ebooks.index') }}">সব দেখুন <i class="fa-solid fa-arrow-right ms-1"></i></a>
    </div>
    <div class="ebd-grid">
      @foreach($gridEbooks as $g)
      @php $gDisc = ($g->discount>0 && $g->price>0) ? round($g->discount/$g->price*100) : 0; @endphp
      <div class="ebd-card">
        <div class="ebd-card-thumb">
          @if($g->cover_image)
            <img src="{{ asset('storage/ebook_covers/'.$g->cover_image) }}" alt="{{ $g->title_en }}">
          @else
            <div class="ph"><i class="fa-solid fa-book-open"></i></div>
          @endif
          @if($g->is_free) <span class="ebd-card-badge free">ফ্রি</span>
          @elseif($gDisc>0) <span class="ebd-card-badge disc">{{ $gDisc }}% OFF</span>
          @endif
        </div>
        <div class="ebd-card-body">
          <div class="ebd-card-title"><a href="{{ route('ebooks.show', $g->id) }}">{{ $g->title_bn ?? $g->title_en }}</a></div>
          <div class="ebd-card-author">{{ $g->author_name ?? '—' }}</div>
          <div class="ebd-card-foot">
            <div class="ebd-card-price">
              @if($g->is_free) <span style="color:#16a34a;">ফ্রি</span>
              @else ৳{{ number_format($g->final_price,0) }}
                @if($gDisc>0) <del>৳{{ number_format($g->price,0) }}</del> @endif
              @endif
            </div>
            <a href="{{ route('ebooks.show', $g->id) }}" class="ebd-card-cart"><i class="fa-solid fa-arrow-right"></i></a>
          </div>
        </div>
      </div>
      @endforeach
    </div>
    @endif

  </div>
</div>

{{-- ═══ Preview Modal ═══ --}}
<div class="eb-modal-overlay" id="ebPreviewOverlay">
  <div class="eb-modal-box">
    <div class="eb-modal-head">
      <h4><i class="fa-solid fa-book-open me-2" style="color:var(--accent);"></i>{{ $ebook->title_bn ?? $ebook->title_en }}</h4>
      <button class="eb-modal-close" id="ebPreviewClose"><i class="fa-solid fa-xmark"></i></button>
    </div>
    <div class="eb-modal-body">
      <div class="eb-modal-pdf">
        <div class="eb-modal-loader" id="ebPdfLoader">
          <i class="fa-solid fa-spinner fa-spin fa-2x"></i>
          <p style="font-size:13px;margin-top:12px;">প্রিভিউ লোড হচ্ছে...</p>
        </div>
        <iframe id="ebPdfFrame" class="eb-modal-frame" src="" allowfullscreen></iframe>
      </div>
      <div class="eb-modal-side">
        @if($ebook->cover_image)<img src="{{ asset('storage/ebook_covers/'.$ebook->cover_image) }}" alt="">@endif
        <p style="font-size:13px;font-weight:800;color:var(--primary);margin:0 0 2px;line-height:1.3;">{{ $ebook->title_bn ?? $ebook->title_en }}</p>
        <p style="font-size:12px;color:var(--text-muted);margin:0 0 14px;">{{ $ebook->author_name ?? '—' }}</p>
        <div style="font-size:22px;font-weight:900;color:var(--accent);">
          @if($ebook->isFree()) ফ্রি @else ৳{{ number_format($ebook->final_price,0) }} @endif
        </div>
        <div style="margin-top:auto;display:flex;flex-direction:column;gap:8px;padding-top:14px;">
          @if(!$isEnrolled && !$ebook->isFree())
          <button id="ebModalBuyBtn" data-url="{{ route('ebooks.buy',$ebook->id) }}" class="ebd-btn-primary ebd-btn-accent" style="padding:10px 14px;font-size:13px;border-radius:10px;justify-content:center;">
            <i class="fa-solid fa-cart-shopping"></i> এখনই কিনুন
          </button>
          @endif
          <button id="ebPreviewClose2" class="ebd-btn-outline" style="padding:9px 14px;font-size:13px;border-radius:10px;justify-content:center;">
            <i class="fa-solid fa-xmark"></i> বন্ধ করুন
          </button>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('js')
<script>
(function(){
    var overlay=document.getElementById('ebPreviewOverlay');
    var frame=document.getElementById('ebPdfFrame');
    var loader=document.getElementById('ebPdfLoader');
    var PREV_URL='{{ route("ebooks.preview") }}';
    var BUY_URL='{{ route("ebooks.buy", $ebook->id) }}';
    var CHECKOUT='{{ route("new.checkout") }}';

    function openPreview(eid){
        overlay.classList.add('open'); document.body.style.overflow='hidden';
        frame.style.display='none'; frame.src=''; loader.style.display='block';
        loader.innerHTML='<i class="fa-solid fa-spinner fa-spin fa-2x"></i><p style="font-size:13px;margin-top:12px;">প্রিভিউ লোড হচ্ছে...</p>';
        $.get(PREV_URL,{id:eid},function(res){
            if(res.pdf_url){ frame.onload=function(){loader.style.display='none';frame.style.display='block';}; frame.src=res.pdf_url; }
            else { loader.innerHTML='<p style="color:#fff;font-size:14px;margin-top:8px;">প্রিভিউ পাওয়া যায়নি।</p>'; }
        });
    }
    function closePreview(){ overlay.classList.remove('open'); document.body.style.overflow=''; frame.src=''; frame.style.display='none'; }

    document.querySelectorAll('.ebook-preview-trigger').forEach(function(b){ b.addEventListener('click',function(){ openPreview(this.dataset.eid); }); });
    document.getElementById('ebPreviewClose').addEventListener('click',closePreview);
    document.getElementById('ebPreviewClose2').addEventListener('click',closePreview);
    overlay.addEventListener('click',function(e){ if(e.target===overlay) closePreview(); });
    document.addEventListener('keydown',function(e){ if(e.key==='Escape') closePreview(); });

    function doBuy(btn){
        if(!btn||btn.disabled) return;
        var orig=btn.innerHTML; btn.disabled=true; btn.innerHTML='<i class="fa-solid fa-spinner fa-spin me-2"></i>যোগ হচ্ছে...';
        $.ajax({ url:BUY_URL, method:'GET', dataType:'json', headers:{'X-Requested-With':'XMLHttpRequest'},
            success:function(res){
                if(res.login_required){ btn.disabled=false; btn.innerHTML=orig;
                    Swal.fire({icon:'warning',title:'লগইন করুন',text:'কার্টে যোগ করতে প্রথমে লগইন করুন।',confirmButtonText:'লগইন',confirmButtonColor:'#2b2553'})
                        .then(function(r){ if(r.isConfirmed) location.href='{{ route("login") }}'; }); return; }
                if(res.status){
                    document.querySelectorAll('.cartCount').forEach(function(el){ el.textContent=res.cartCount||''; });
                    if(typeof showCartNotification==='function') showCartNotification(res.message||'কার্টে যোগ হয়েছে!','success');
                    location.href=CHECKOUT;
                }
            },
            error:function(xhr){ btn.disabled=false; btn.innerHTML=orig;
                if(xhr.status===401){ Swal.fire({icon:'warning',title:'লগইন করুন',text:'কার্টে যোগ করতে প্রথমে লগইন করুন।',confirmButtonText:'লগইন',confirmButtonColor:'#2b2553'})
                    .then(function(r){ if(r.isConfirmed) location.href='{{ route("login") }}'; }); }
            }
        });
    }
    ['ebookBuyBtn','ebModalBuyBtn'].forEach(function(id){ var el=document.getElementById(id); if(el) el.addEventListener('click',function(){doBuy(this);}); });

    // ── Tabs ──
    document.querySelectorAll('.ebd-tab').forEach(function(tab){
        tab.addEventListener('click', function(){
            var name = this.dataset.tab;
            document.querySelectorAll('.ebd-tab').forEach(function(t){ t.classList.remove('active'); });
            document.querySelectorAll('.ebd-tab-panel').forEach(function(p){ p.classList.remove('active'); });
            this.classList.add('active');
            var panel = document.getElementById('tab-' + name);
            if(panel) panel.classList.add('active');
        });
    });
})();
</script>
@endpush
