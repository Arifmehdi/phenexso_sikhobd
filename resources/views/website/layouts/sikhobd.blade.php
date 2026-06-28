<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', $ws->website_title ?? 'Qalam HR')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description', $ws->meta_description ?? 'QalamHR is one of the premier training institutes in Bangladesh. We create professionals.')">
    @yield('meta')
    
    <link rel="shortcut icon" type="image/png" href="{{ route('imagecache', ['template' => 'original', 'filename' => $ws->favicon()]) }}">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('sikhobd/css/style.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    
    <style>
        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
            background: var(--bg, #ffffff);
            color: var(--text-main, inherit);
            line-height: 1.6;
        }

        main {
            padding: 0 0 60px;
        }

        /* ============================================================
           SITE HEADER  —  mobile-first, pure flexbox, no grid
        ============================================================ */
        .site-header {
            position: sticky;
            top: 0;
            z-index: 1100;
            background: rgba(255,255,255,0.97);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            box-shadow: 0 2px 16px rgba(15,23,42,0.07);
            width: 100%;
        }

        /* =============================================================
           HEADER ROW
           Mobile:  [☰] [Logo]  ·····  [🔍] [👤] [🌐]
           Desktop: [Logo] [──search──────────] [Lang] [User] [Login]
        ============================================================= */
        .sh-inner {
            display: flex;
            align-items: center;
            padding: 10px 0;
            gap: 10px;
            min-height: 60px;
        }

        /* Logo */
        .sh-logo { display: flex; flex-shrink: 0; text-decoration: none; }
        .sh-logo img { max-height: 52px; display: block; }
        .logo img  { max-height: 52px; display: block; }

        /* Hamburger — leftmost on mobile, hidden on desktop */
        .sh-burger { font-size: 18px; }

        /* =============================================================
           DESKTOP SEARCH  (hidden on mobile, shown ≥ 992px)
        ============================================================= */
        .sh-search-wrap {
            display: none;
            flex: 1;
            max-width: 560px;
            margin: 0 auto;
            position: relative;
        }
        .sh-search-box {
            display: flex;
            align-items: center;
            background: #f1f5f9;
            border: 1.5px solid #e2e8f0;
            border-radius: 50px;
            padding: 0 5px 0 16px;
            gap: 6px;
            transition: border-color 0.2s, background 0.2s, box-shadow 0.2s;
        }
        .sh-search-box:focus-within {
            border-color: var(--primary, #2952ff);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(41,82,255,0.09);
        }
        .sh-search-ico { color: #94a3b8; font-size: 14px; flex-shrink: 0; }
        .sh-search-inp {
            flex: 1; border: none; outline: none;
            background: transparent; font-size: 14px; color: #1e293b;
            padding: 11px 0; caret-color: var(--primary, #2952ff);
        }
        .sh-search-inp::placeholder { color: #94a3b8; }
        .sh-search-clr {
            background: none; border: none; cursor: pointer;
            color: #94a3b8; font-size: 13px; padding: 4px;
            display: inline-flex; align-items: center;
        }
        .sh-search-go {
            background: var(--primary, #2952ff); color: #fff;
            border: none; border-radius: 50px;
            width: 36px; height: 36px;
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 13px; cursor: pointer; flex-shrink: 0;
            transition: background 0.2s;
        }
        .sh-search-go:hover { background: #1a3fd0; }

        /* Suggestions dropdown */
        .sh-search-drop {
            position: absolute;
            top: calc(100% + 8px);
            left: 0; right: 0;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 12px 40px rgba(15,23,42,0.13);
            border: 1px solid #e2e8f0;
            z-index: 1500;
            display: none;
            max-height: 440px;
            overflow-y: auto;
            overflow-x: hidden;
        }
        .sh-search-drop.open { display: block; }

        /* =============================================================
           RIGHT ACTIONS
        ============================================================= */
        .sh-right {
            display: flex;
            align-items: center;
            gap: 7px;
            margin-left: auto;
            flex-shrink: 0;
        }

        /* Universal icon circle button */
        .sh-icon-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px; height: 40px;
            border-radius: 50%;
            border: 1.5px solid rgba(148,163,184,0.22);
            background: transparent;
            color: #475569;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
            flex-shrink: 0;
            transition: background 0.18s, border-color 0.18s, color 0.18s;
        }
        .sh-icon-btn:hover {
            background: rgba(41,82,255,0.07);
            border-color: var(--primary, #2952ff);
            color: var(--primary, #2952ff);
        }

        /* Desktop language pill */
        .sh-lang-pill {
            display: inline-flex;
            gap: 2px;
            background: #f1f5f9;
            border: 1.5px solid #e2e8f0;
            border-radius: 999px;
            padding: 3px;
        }
        .sh-lang-pill button {
            min-width: 38px; border: none; background: transparent;
            color: #64748b; font-weight: 700; font-size: 12px;
            padding: 6px 10px; border-radius: 999px; cursor: pointer;
            transition: background 0.18s, color 0.18s;
        }
        .sh-lang-pill button:hover,
        .sh-lang-pill button.active { background: var(--primary, #2952ff); color: #fff; }

        /* Login text pill (desktop) */
        .sh-login-btn {
            display: inline-flex; align-items: center;
            padding: 9px 20px;
            border: 1.5px solid var(--primary, #2952ff);
            color: var(--primary, #2952ff);
            border-radius: 999px;
            font-weight: 600; font-size: 14px;
            text-decoration: none; white-space: nowrap;
            transition: background 0.2s, color 0.2s;
        }
        .sh-login-btn:hover { background: var(--primary, #2952ff); color: #fff; }

        /* User dropdown wrapper */
        .sh-user {
            position: relative;
            display: inline-flex;
            align-items: center;
        }
        .sh-user .dropdown {
            top: calc(100% + 8px);
            left: auto; right: 0;
            min-width: 200px;
        }
        /* Mobile dropdown opens right from right edge, not off-screen */
        .sh-mob-dd { right: 0 !important; left: auto !important; }

        /* =============================================================
           VISIBILITY HELPERS
           .sh-mob  = shown on mobile, hidden on desktop
           .sh-dsk  = hidden on mobile, shown on desktop
        ============================================================= */
        .sh-dsk { display: none !important; }
        .sh-mob { display: inline-flex !important; align-items: center; }

        @media (min-width: 992px) {
            .sh-search-wrap { display: block; }
            .sh-dsk { display: inline-flex !important; }
            .sh-mob { display: none !important; }
            .sh-inner { gap: 16px; }
            .sh-right { gap: 8px; }
        }

        /* =============================================================
           GLOBE LANGUAGE DROPDOWN  (mobile)
        ============================================================= */
        .sh-globe-wrap {
            position: relative;
            display: inline-flex;
            align-items: center;
        }
        .sh-globe-drop {
            position: absolute;
            top: calc(100% + 6px);
            right: 0;
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            box-shadow: 0 8px 28px rgba(15,23,42,0.14);
            padding: 4px;
            min-width: 116px;
            display: none;
            z-index: 2100;
        }
        .sh-globe-drop.open { display: block; }
        .sh-globe-opt {
            display: flex; align-items: center; gap: 8px;
            padding: 9px 13px; font-size: 13px; font-weight: 600;
            color: #475569; text-decoration: none; border-radius: 8px;
            transition: background 0.15s, color 0.15s;
        }
        .sh-globe-opt:hover  { background: #f1f5f9; color: #1e293b; }
        .sh-globe-opt.is-active { color: var(--primary, #2952ff); }
        .sh-globe-chk { font-size: 10px; opacity: 0; }
        .sh-globe-opt.is-active .sh-globe-chk { opacity: 1; }

        /* =============================================================
           MOBILE OVERRIDES
        ============================================================= */
        @media (max-width: 991px) {
            .sh-inner {
                padding: 7px 0;
                min-height: 50px;
                gap: 6px;
            }
            .sh-logo img { max-height: 36px; }
            .sh-right { gap: 3px; }
            /* Slightly smaller icon buttons on mobile */
            .sh-icon-btn {
                width: 34px;
                height: 34px;
                font-size: 13px;
                border-width: 1px;
            }
            .sh-burger { font-size: 16px; }
        }

        /* =============================================================
           SEARCH RESULT TYPE BADGES
        ============================================================= */
        .sr-badge {
            display: inline-flex; align-items: center; gap: 3px;
            font-size: 10px; font-weight: 700; letter-spacing: 0.3px;
            padding: 2px 7px; border-radius: 999px; text-transform: uppercase;
        }
        .sr-badge-product { background: #dcfce7; color: #15803d; }
        .sr-badge-course  { background: #dbeafe; color: #1d4ed8; }
        .sr-badge-ebook   { background: #fff7ed; color: #c2410c; }

        /* Cart icon button (all result types) */
        .sr-cart-btn {
            flex-shrink: 0;
            width: 36px; height: 36px;
            border-radius: 50%;
            border: 1.5px solid var(--primary, #2952ff);
            background: transparent;
            color: var(--primary, #2952ff);
            font-size: 14px;
            cursor: pointer;
            display: inline-flex; align-items: center; justify-content: center;
            transition: background 0.18s, color 0.18s, border-color 0.18s;
        }
        .sr-cart-btn:hover:not(:disabled) {
            background: var(--primary, #2952ff);
            color: #fff;
        }
        .sr-cart-btn:disabled { cursor: not-allowed; opacity: 0.6; }
        /* In-cart state — stays green permanently */
        .sr-cart-btn.sr-cart-in, .sr-cart-btn.sr-cart-in:disabled {
            background: #dcfce7;
            border-color: #16a34a;
            color: #16a34a;
            opacity: 1;
            cursor: default;
        }

        /* Shared result card (used in both dropdown and drawer) */
        .sr-card {
            display: flex; align-items: center; gap: 12px;
            padding: 10px 14px;
            border-bottom: 1px solid #f1f5f9;
            transition: background 0.15s;
        }
        .sr-card:last-of-type { border-bottom: none; }
        .sr-card:hover { background: #f8fafc; }
        .sr-img {
            width: 56px; height: 56px; object-fit: cover;
            border-radius: 8px; border: 1px solid #e2e8f0; flex-shrink: 0;
        }
        .sr-info { flex: 1; min-width: 0; }
        .sr-name {
            font-size: 14px; font-weight: 600; color: #1e293b;
            text-decoration: none; display: block;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
            margin-bottom: 4px; transition: color 0.15s;
        }
        .sr-name:hover { color: var(--primary, #2952ff); }
        .sr-price-final { font-size: 14px; font-weight: 700; color: var(--primary, #2952ff); }
        .sr-price-orig { font-size: 12px; color: #94a3b8; text-decoration: line-through; margin-left: 6px; }
        .sr-btn {
            flex-shrink: 0; padding: 7px 12px;
            font-size: 12px; font-weight: 600;
            border: none; border-radius: 8px;
            background: var(--primary, #2952ff); color: #fff;
            cursor: pointer; white-space: nowrap;
            transition: background 0.2s, transform 0.15s;
        }
        .sr-btn:hover:not(:disabled) { background: #1a3fd0; transform: scale(1.04); }
        .sr-btn:disabled { background: #94a3b8; cursor: not-allowed; transform: none; }
        .sr-btn.added { background: #16a34a; }
        .sr-state {
            padding: 28px 16px; text-align: center;
            color: #94a3b8; font-size: 14px; line-height: 1.8;
        }
        .sr-state i { font-size: 24px; margin-bottom: 8px; display: block; color: #cbd5e1; }
        .sr-loading i { animation: sr-spin 0.8s linear infinite; color: var(--primary, #2952ff); }
        @keyframes sr-spin { to { transform: rotate(360deg); } }
        .sr-view-all {
            display: flex; align-items: center; justify-content: center;
            padding: 11px 14px; font-size: 13px; font-weight: 600;
            color: var(--primary, #2952ff); text-decoration: none;
            border-top: 1px solid #f1f5f9;
            transition: background 0.15s;
        }
        .sr-view-all:hover { background: #f0f5ff; }

        /* ---- Login button ---- */
        .btn-login {
            display: inline-flex; align-items: center;
            padding: 9px 18px;
            border: 1.5px solid var(--primary, #2952ff);
            color: var(--primary, #2952ff);
            border-radius: 999px;
            font-weight: 600; font-size: 14px;
            text-decoration: none;
            transition: background 0.2s, color 0.2s;
            white-space: nowrap;
        }
        .btn-login:hover { background: var(--primary, #2952ff); color: #fff; }

        .header-bottom {
            padding: 8px 0;
            border-top: 1px solid rgba(148, 163, 184, 0.10);
        }

        .nav-center {
            display: flex;
            justify-content: flex-start;
        }

        .logo img {
            max-height: 60px;
            transition: transform 0.3s ease;
        }

        .logo img:hover {
            transform: translateY(-2px);
        }

        .nav-desktop {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .nav-item {
            position: relative;
        }

        .nav-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--text-main, inherit);
            font-weight: 600;
            padding: 10px 14px;
            border-radius: 999px;
            transition: background 0.2s ease, color 0.2s ease, transform 0.2s ease;
            text-decoration: none;
        }

        .nav-link:hover,
        .nav-link:focus {
            background: rgba(41, 82, 255, 0.1);
            color: var(--primary, #2b2553);
            transform: translateY(-1px);
        }

        .caret,
        .arrow {
            width: 10px;
            height: 10px;
            display: inline-block;

        }

        .dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            min-width: 240px;
            background: #ffffff;
            border: 1px solid rgba(148, 163, 184, 0.18);
            border-radius: 20px;
            padding: 12px 0;
            box-shadow: 0 20px 50px rgba(15, 23, 42, 0.12);
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: opacity 0.3s ease, transform 0.3s cubic-bezier(0.23, 1, 0.32, 1), visibility 0.3s;
            z-index: 1000;
            pointer-events: none;
        }

        /* Bridge the gap between nav-item and dropdown to maintain hover */
        .dropdown::before {
            content: '';
            position: absolute;
            top: -15px;
            left: 0;
            right: 0;
            height: 15px;
            background: transparent;
        }

        .nav-item:hover > .dropdown,
        .nav-item:focus-within > .dropdown,
        .dropdown-item:hover > .dropdown,
        .user-dropdown:hover > .dropdown {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
            pointer-events: auto;
        }

        .dropdown-item {
            position: relative;
            list-style: none;
            padding: 2px 8px;
        }

        .dropdown-item > .dropdown {
            top: 0;
            left: 100%;
            margin-top: -12px;
            margin-left: -4px;
            transform: translateX(10px);
        }

        .dropdown-item:hover > .dropdown {
            transform: translateX(0);
        }

        .dropdown-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 16px;
            color: #334155;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s ease;
            border-radius: 12px;
        }

        .dropdown-link:hover,
        .dropdown-link:focus {
            background: #f8fafc;
            color: var(--primary, #2952ff);
            transform: translateX(4px);
        }

        .dropdown-link span {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .dropdown-link .arrow {
            width: 8px;
            height: 8px;
            opacity: 0.6;
            transition: transform 0.2s ease;
        }

        .dropdown-item:hover > .dropdown-link .arrow {
            transform: translateX(2px);
            opacity: 1;
        }

        .drawer-overlay {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.45);
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.25s ease, visibility 0.25s ease;
            z-index: 1290;
            pointer-events: none;
        }
        .drawer-overlay.open {
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
        }

        /* Drawer slides LEFT → RIGHT via transform (reliable on all devices) */
        .drawer {
            position: fixed;
            top: 0;
            left: 0;
            transform: translateX(-100%);
            width: 300px;
            max-width: 85vw;
            height: 100vh;
            background: #ffffff;
            box-shadow: 4px 0 32px rgba(15, 23, 42, 0.16);
            transition: transform 0.28s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1300;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        .drawer.open {
            transform: translateX(0);
        }

        .drawer-head {
            padding: 20px 18px;
            border-bottom: 1px solid rgba(148, 163, 184, 0.18);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .drawer-body {
            padding: 18px;
            overflow-y: auto;
            gap: 14px;
            display: flex;
            flex-direction: column;
        }

        .drawer-search input {
            width: 100%;
            padding: 14px 16px;
            border-radius: 16px;
            border: 1px solid rgba(148, 163, 184, 0.18);
            outline: none;
            font-size: 1rem;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .drawer-search input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(41, 82, 255, 0.08);
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .icon-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 46px;
            height: 46px;
            border-radius: 16px;
            border: 1px solid rgba(148, 163, 184, 0.18);
            background: var(--surface);
            color: var(--text-main);
            cursor: pointer;
            transition: transform 0.2s ease, background 0.2s ease, border-color 0.2s ease;
        }

        .menu-toggle {
            display: none;
            align-items: center;
            justify-content: center;
            width: 46px;
            height: 46px;
            border-radius: 16px;
            border: 1px solid rgba(148, 163, 184, 0.18);
            background: var(--surface);
            color: var(--text-main);
            cursor: pointer;
            transition: transform 0.2s ease, background 0.2s ease, border-color 0.2s ease;
        }

        .icon-btn:hover,
        .menu-toggle:hover {
            transform: translateY(-1px);
            border-color: rgba(41, 82, 255, 0.24);
            background: var(--surface-soft);
        }

        .lang-switch {
            display: inline-flex;
            gap: 6px;
            border: 1px solid rgba(148, 163, 184, 0.18);
            background: var(--surface);
            border-radius: 999px;
            padding: 4px;
        }

        .lang-switch button {
            min-width: 42px;
            border: none;
            background: transparent;
            color: var(--text-muted);
            font-weight: 700;
            padding: 10px 12px;
            border-radius: 999px;
            cursor: pointer;
            transition: background 0.2s ease, color 0.2s ease;
        }

        .lang-switch button:hover,
        .lang-switch button:focus {
            background: var(--surface-soft);
            color: var(--text-main);
        }

        .btn-primary,
        .btn-primary:focus,
        .btn-primary:hover {
            background: var(--primary);
            border-color: var(--primary);
            color: #fff;
            box-shadow: 0 20px 40px rgba(41, 82, 255, 0.16);
        }

        .btn-outline-primary {
            color: var(--primary);
            border-color: var(--primary);
        }

        .btn-outline-primary:hover {
            background: rgba(41, 82, 255, 0.08);
            color: var(--primary);
        }

        .form-control {
            border-radius: 16px;
            border: 1px solid rgba(148, 163, 184, 0.22);
            box-shadow: none;
            min-height: 50px;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(41, 82, 255, 0.08);
        }

        .card {
            border: 1px solid rgba(148, 163, 184, 0.14);
            border-radius: 24px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 24px 60px rgba(15, 23, 42, 0.08);
        }

        .card-body {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .search-results-page {
            min-height: calc(100vh - 160px);
        }

        .search-results-page h1,
        .search-results-page h3 {
            font-weight: 700;
        }

        .btn-group .btn {
            border-radius: 999px;
        }

        .btn-group .btn.active,
        .btn-group .btn:hover {
            background: var(--primary-soft);
            border-color: var(--primary);
            color: var(--primary);
        }

        .floating-whatsapp {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            background: #25D366;
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 16px 40px rgba(37, 211, 102, 0.3);
            z-index: 999;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 32px;
        }

        .floating-whatsapp:hover {
            transform: translateY(-5px) scale(1.1);
            color: #fff;
            box-shadow: 0 24px 60px rgba(37, 211, 102, 0.4);
        }

        .floating-whatsapp::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background: inherit;
            border-radius: 50%;
            z-index: -1;
            animation: pulse-whatsapp 2s infinite;
        }

        @keyframes pulse-whatsapp {
            0% { transform: scale(1); opacity: 0.6; }
            100% { transform: scale(1.6); opacity: 0; }
        }

        .floating-cart {
            position: fixed;
            bottom: 105px;
            right: 30px;
            width: 60px;
            height: 60px;
            background: var(--primary);
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 16px 40px rgba(41, 82, 255, 0.24);
            z-index: 999;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 24px;
        }

        .floating-cart:hover {
            transform: translateY(-5px) scale(1.1);
            color: #fff;
            box-shadow: 0 24px 60px rgba(41, 82, 255, 0.28);
        }

        .floating-cart .cart-count-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: var(--accent);
            color: #fff;
            font-size: 12px;
            font-weight: 800;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #fff;
            box-shadow: 0 8px 18px rgba(15, 23, 42, 0.14);
        }

        @media (max-width: 768px) {
            .floating-whatsapp {
                bottom: 20px; right: 20px;
                width: 54px; height: 54px; font-size: 28px;
            }
            .floating-cart {
                bottom: 85px; right: 20px;
                width: 54px; height: 54px; font-size: 20px;
            }
            .nav-desktop { display: none; }
        }

        .user-dropdown {
            position: relative;
            display: inline-flex;
            align-items: center;
            height: 100%;
        }

        .user-dropdown .dropdown {
            left: auto;
            right: 0;
            min-width: 200px;
            margin-top: 8px;
        }

        .user-dropdown .dropdown-link {
            display: flex;
            align-items: center;
            padding: 10px 18px;
            color: var(--text-main);
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .user-dropdown .dropdown-link:hover {
            background: var(--surface-soft);
            color: var(--primary);
        }

        .user-dropdown .dropdown-link.text-danger:hover {
            background: #fff5f5;
        }

        /* ====== Search Drawer ====== */
        .search-drawer-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.52);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s;
            z-index: 1200;
        }
        .search-drawer-backdrop.open {
            opacity: 1;
            visibility: visible;
        }

        .search-drawer {
            position: fixed;
            top: 0;
            right: -100%;
            width: 420px;
            max-width: 100vw;
            height: 100vh;
            background: #fff;
            z-index: 1300;
            display: flex;
            flex-direction: column;
            box-shadow: -6px 0 40px rgba(15, 23, 42, 0.14);
            transition: right 0.32s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .search-drawer.open { right: 0; }

        .sd-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 20px;
            border-bottom: 1px solid rgba(148, 163, 184, 0.15);
            background: #f8fafc;
            flex-shrink: 0;
        }
        .sd-title {
            font-size: 16px;
            font-weight: 700;
            color: #1e293b;
            display: flex;
            align-items: center;
        }
        .sd-close {
            width: 36px; height: 36px;
            border: none;
            background: #e2e8f0;
            border-radius: 50%;
            display: grid;
            place-items: center;
            cursor: pointer;
            color: #475569;
            font-size: 15px;
            transition: background 0.2s;
            flex-shrink: 0;
        }
        .sd-close:hover { background: #cbd5e1; color: #1e293b; }

        .sd-input-wrap {
            display: flex;
            align-items: center;
            padding: 14px 18px;
            gap: 10px;
            border-bottom: 1px solid rgba(148, 163, 184, 0.12);
            flex-shrink: 0;
        }
        .sd-search-icon { color: #94a3b8; font-size: 16px; flex-shrink: 0; }
        .sd-input {
            flex: 1;
            border: none;
            outline: none;
            font-size: 16px;
            color: #1e293b;
            background: transparent;
            caret-color: var(--primary, #2952ff);
        }
        .sd-input::placeholder { color: #94a3b8; }
        .sd-clear {
            background: none; border: none;
            cursor: pointer; color: #94a3b8;
            font-size: 14px; padding: 4px; line-height: 1;
            display: inline-flex; align-items: center;
        }
        .sd-clear:hover { color: #475569; }

        /* drawer results area — cards inside use shared .sr-* classes */
        .sd-results { flex: 1; overflow-y: auto; padding: 0; }
        .sd-footer { padding: 14px 18px; border-top: 1px solid #f1f5f9; flex-shrink: 0; }
        .sd-view-all {
            display: none; /* footer link hidden; "view all" appears inside .sr-view-all in results */
        }
        @media (max-width: 480px) {
            .search-drawer { width: 100%; }
        }

        body.no-scroll { overflow: hidden; }

        .scroll-top {
            position: fixed;
            bottom: 30px;
            left: 30px;
            width: 50px;
            height: 50px;
            background: #fff;
            color: var(--primary, #2b2553);
            border: 2px solid var(--primary, #2b2553);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            cursor: pointer;
            z-index: 998;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            transform: translateY(20px);
        }

        .scroll-top.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .scroll-top:hover {
            background: var(--primary, #2b2553);
            color: #fff;
            transform: translateY(-5px);
        }

        @media (max-width: 768px) {
            .scroll-top {
                bottom: 20px;
                left: 20px;
                width: 44px;
                height: 44px;
                font-size: 18px;
            }
        }

        .swal2-container {
            z-index: 9999 !important;
        }
    </style>

    @stack('css')
</head>
<body>

    @include('website.layouts.sikhobd_header')

    <main>
        @yield('content')
    </main>

    @if($ws->whatsapp)
    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $ws->whatsapp) }}" class="floating-whatsapp" target="_blank" title="Chat with us on WhatsApp">
        <i class="fa-brands fa-whatsapp"></i>
    </a>
    @endif

    <div class="scroll-top" id="scrollTop" title="Go to Top">
        <i class="fa-solid fa-arrow-up"></i>
    </div>

    <a href="{{ route('cart') }}" class="floating-cart">
        <i class="fa-solid fa-cart-shopping"></i>
        <span class="cart-count-badge cartCount">{{ $cartCount ?? 0 }}</span>
    </a>

    @include('website.layouts.sikhobd_footer')

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('sikhobd/js/main.js') }}"></script>
    
    <script>
        // Global AJAX Cart Notification Helper
        function showCartNotification(message, type = 'success') {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            Toast.fire({
                icon: type,
                title: message
            });
        }

        document.addEventListener('DOMContentLoaded', function () {

            const LIVE_SEARCH_URL = '{{ route("liveProductSearch") }}';
            const SEARCH_PAGE_URL = '{{ route("search") }}';
            const CSRF_TOKEN      = document.querySelector('meta[name="csrf-token"]')?.content || '';
            const PLACEHOLDER_IMG = '{{ asset("sikhobd/img/placeholder.png") }}';

            /* =====================================================
               SHARED HELPERS
            ===================================================== */
            function esc(str) {
                return String(str)
                    .replace(/&/g,'&amp;').replace(/</g,'&lt;')
                    .replace(/>/g,'&gt;').replace(/"/g,'&quot;');
            }

            var TYPE_CFG = {
                'product': { label: 'Product', cls: 'sr-badge-product', icon: 'fa-bag-shopping' },
                'course':  { label: 'Course',  cls: 'sr-badge-course',  icon: 'fa-graduation-cap' },
                'ebook':   { label: 'E-book',  cls: 'sr-badge-ebook',   icon: 'fa-book-open' }
            };

            function buildCard(p) {
                var fp   = parseFloat(p.final_price   || p.selling_price || 0);
                var op   = parseFloat(p.selling_price || 0);
                var dis  = parseFloat(p.discount || 0) > 0;
                var nm   = esc(p.name);
                var type = p.item_type || 'product';
                var cfg  = TYPE_CFG[type] || TYPE_CFG['product'];

                // Price
                var isFree = p.is_free || fp === 0;
                var priceHtml = isFree
                    ? '<span class="sr-price-final">Free</span>'
                    : '<span class="sr-price-final">৳' + fp.toFixed(0) + '</span>'
                      + (dis ? '<span class="sr-price-orig">৳' + op.toFixed(0) + '</span>' : '');

                // Type badge
                var badge = '<span class="sr-badge ' + cfg.cls + '">'
                    + '<i class="fa-solid ' + cfg.icon + '"></i> ' + cfg.label + '</span>';

                // Cart button — same icon for all types
                var canAdd  = type === 'product' ? !!p.in_stock : true;
                var inCart  = !!p.in_cart;
                var cartBtn;
                if (inCart) {
                    // Already in cart → green check, disabled
                    cartBtn = '<button class="sr-cart-btn sr-cart-in" disabled title="In Cart">'
                        + '<i class="fa-solid fa-check"></i></button>';
                } else if (!canAdd) {
                    // Out of stock
                    cartBtn = '<button class="sr-cart-btn" disabled title="Out of stock">'
                        + '<i class="fa-solid fa-ban"></i></button>';
                } else {
                    // Available to add
                    cartBtn = '<button class="sr-cart-btn"'
                        + ' data-item-type="' + type + '"'
                        + ' data-id="' + p.id + '"'
                        + ' data-cart-url="' + esc(p.cart_url) + '"'
                        + ' title="Add to cart">'
                        + '<i class="fa-solid fa-cart-plus"></i></button>';
                }

                return '<div class="sr-card">'
                    + '<a href="' + esc(p.url) + '" style="flex-shrink:0;display:block">'
                    + '<img class="sr-img" src="' + esc(p.image) + '" alt="' + nm + '" '
                    + 'onerror="this.onerror=null;this.src=\'' + PLACEHOLDER_IMG + '\'">'
                    + '</a>'
                    + '<div class="sr-info">'
                    + '<a href="' + esc(p.url) + '" class="sr-name">' + nm + '</a>'
                    + '<div style="display:flex;align-items:center;gap:5px;flex-wrap:wrap;margin-top:3px">'
                    + priceHtml + badge
                    + '</div>'
                    + '</div>'
                    + cartBtn
                    + '</div>';
            }

            function buildResults(data, q, viewAllEl, resultsEl) {
                if (!data.length) {
                    resultsEl.innerHTML = '<div class="sr-state"><i class="fa-solid fa-magnifying-glass"></i>No products found for &ldquo;<strong>' + esc(q) + '</strong>&rdquo;</div>';
                    if (viewAllEl) viewAllEl.style.display = 'none';
                    return;
                }
                var html = data.map(buildCard).join('');
                html += '<a class="sr-view-all" href="' + SEARCH_PAGE_URL + '?q=' + encodeURIComponent(q) + '">View all results <i class="fa-solid fa-arrow-right" style="margin-left:6px"></i></a>';
                resultsEl.innerHTML = html;
                if (viewAllEl) viewAllEl.style.display = 'none'; // drawer footer link handled via card
            }

            function doSearch(q, resultsEl, viewAllEl) {
                if (!q) { resultsEl.innerHTML = ''; if (viewAllEl) viewAllEl.style.display = 'none'; return; }
                resultsEl.innerHTML = '<div class="sr-state sr-loading"><i class="fa-solid fa-spinner"></i> Searching…</div>';
                fetch(LIVE_SEARCH_URL + '?q=' + encodeURIComponent(q), {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(function(r) { return r.json(); })
                .then(function(data) { buildResults(data, q, viewAllEl, resultsEl); })
                .catch(function() {
                    resultsEl.innerHTML = '<div class="sr-state">Search failed. Please try again.</div>';
                });
            }

            function debounce(fn, ms) {
                var t; return function() { var args = arguments; clearTimeout(t); t = setTimeout(function(){ fn.apply(null, args); }, ms); };
            }

            function addToCart(btn) {
                if (btn.disabled) return;
                var itemType = btn.dataset.itemType || 'product';
                var itemId   = btn.dataset.id;
                var cartUrl  = btn.dataset.cartUrl;

                btn.disabled  = true;
                btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i>';

                function onSuccess(res) {
                    if (res.login_required) {
                        btn.innerHTML = '<i class="fa-solid fa-cart-plus"></i>';
                        btn.disabled  = false;
                        if (typeof showCartNotification === 'function') {
                            showCartNotification('Please login to add to cart.', 'warning');
                        }
                        return;
                    }
                    if (res.status) {
                        // Mark as "in cart" permanently
                        btn.innerHTML = '<i class="fa-solid fa-check"></i>';
                        btn.classList.add('sr-cart-in');
                        btn.title     = 'In Cart';
                        // Update all cart count badges
                        var count = res.cartCount || res.cartItemsCount || '';
                        document.querySelectorAll('.cartCount, .cartItemsCount').forEach(function(el){ el.textContent = count; });
                        if (typeof showCartNotification === 'function') {
                            showCartNotification(res.message || 'Added to cart!', 'success');
                        }
                    } else {
                        btn.innerHTML = '<i class="fa-solid fa-cart-plus"></i>';
                        btn.disabled  = false;
                    }
                }

                function onError(xhr) {
                    btn.innerHTML = '<i class="fa-solid fa-cart-plus"></i>';
                    btn.disabled  = false;
                    if (xhr && xhr.status === 401) {
                        if (typeof showCartNotification === 'function') {
                            showCartNotification('Please login to add to cart.', 'warning');
                        }
                    } else {
                        if (typeof showCartNotification === 'function') {
                            showCartNotification('Could not add to cart.', 'error');
                        }
                    }
                }

                if (itemType === 'ebook') {
                    // Ebook: GET request (requires auth — server handles redirect)
                    $.ajax({
                        url: cartUrl,
                        method: 'GET',
                        headers: { 'X-Requested-With': 'XMLHttpRequest' },
                        success: onSuccess,
                        error:   onError
                    });
                } else {
                    // Product or Course: POST
                    $.ajax({
                        url: cartUrl,
                        method: 'POST',
                        data: { product: itemId, qty: 1 },
                        headers: { 'X-CSRF-TOKEN': CSRF_TOKEN, 'X-Requested-With': 'XMLHttpRequest' },
                        success: onSuccess,
                        error:   onError
                    });
                }
            }

            /* =====================================================
               DESKTOP INLINE SEARCH (dropdown below bar)
            ===================================================== */
            var hInput    = document.getElementById('headerSearchInput');
            var hDropdown = document.getElementById('headerSearchDropdown');
            var hClear    = document.getElementById('headerSearchClear');
            var hSubmit   = document.getElementById('headerSearchSubmit');

            var deskSearch = debounce(function(q) {
                if (!q) { hDropdown.innerHTML = ''; hDropdown.classList.remove('open'); return; }
                hDropdown.innerHTML = '<div class="sr-state sr-loading"><i class="fa-solid fa-spinner"></i> Searching…</div>';
                hDropdown.classList.add('open');
                fetch(LIVE_SEARCH_URL + '?q=' + encodeURIComponent(q), {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(function(r){ return r.json(); })
                .then(function(data){ buildResults(data, q, null, hDropdown); })
                .catch(function(){ hDropdown.innerHTML = '<div class="sr-state">Search failed.</div>'; });
            }, 280);

            if (hInput) {
                hInput.addEventListener('input', function() {
                    var q = this.value.trim();
                    hClear && (hClear.style.display = q ? 'inline-flex' : 'none');
                    deskSearch(q);
                });
                hInput.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        var q = this.value.trim();
                        if (q) window.location.href = SEARCH_PAGE_URL + '?q=' + encodeURIComponent(q);
                    }
                });
            }
            hClear && hClear.addEventListener('click', function() {
                hInput.value = ''; hDropdown.innerHTML = ''; hDropdown.classList.remove('open');
                hClear.style.display = 'none'; hInput.focus();
            });
            hSubmit && hSubmit.addEventListener('click', function() {
                var q = hInput ? hInput.value.trim() : '';
                if (q) window.location.href = SEARCH_PAGE_URL + '?q=' + encodeURIComponent(q);
            });

            // Delegate add-to-cart inside desktop dropdown
            hDropdown && hDropdown.addEventListener('click', function(e) {
                var btn = e.target.closest('.sr-cart-btn');
                if (btn) addToCart(btn);
            });

            // Close desktop dropdown on outside click
            document.addEventListener('click', function(e) {
                if (hDropdown && !e.target.closest('#headerSearchWrap')) {
                    hDropdown.classList.remove('open');
                }
            });

            /* =====================================================
               SEARCH DRAWER — open / close (mobile + mobile icon)
            ===================================================== */
            var searchDrawer   = document.getElementById('searchDrawer');
            var searchBackdrop = document.getElementById('searchDrawerBackdrop');
            var searchToggle   = document.getElementById('searchToggle');
            var searchClose    = document.getElementById('searchDrawerClose');
            var searchInput    = document.getElementById('searchDrawerInput');
            var searchResults  = document.getElementById('searchDrawerResults');
            var searchClear    = document.getElementById('searchDrawerClear');
            var searchViewAll  = document.getElementById('searchDrawerViewAll');

            function openSearchDrawer() {
                searchDrawer && searchDrawer.classList.add('open');
                searchBackdrop && searchBackdrop.classList.add('open');
                document.body.classList.add('no-scroll');
                setTimeout(function(){ searchInput && searchInput.focus(); }, 300);
            }
            function closeSearchDrawer() {
                searchDrawer && searchDrawer.classList.remove('open');
                searchBackdrop && searchBackdrop.classList.remove('open');
                document.body.classList.remove('no-scroll');
            }

            searchToggle   && searchToggle.addEventListener('click',   function(e){ e.preventDefault(); openSearchDrawer(); });
            searchClose    && searchClose.addEventListener('click',    closeSearchDrawer);
            searchBackdrop && searchBackdrop.addEventListener('click', closeSearchDrawer);

            document.querySelector('.drawer-search-trigger') && document.querySelector('.drawer-search-trigger').addEventListener('click', function() {
                document.getElementById('drawer') && document.getElementById('drawer').classList.remove('open');
                document.getElementById('drawerOverlay') && document.getElementById('drawerOverlay').classList.remove('open');
                document.body.style.overflow = '';
                openSearchDrawer();
            });

            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape' && searchDrawer && searchDrawer.classList.contains('open')) closeSearchDrawer();
            });

            var drawerSearch = debounce(function(q) {
                doSearch(q, searchResults, searchViewAll);
            }, 280);

            searchInput && searchInput.addEventListener('input', function() {
                var q = this.value.trim();
                searchClear && (searchClear.style.display = q ? 'inline-flex' : 'none');
                drawerSearch(q);
            });
            searchClear && searchClear.addEventListener('click', function() {
                searchInput.value = ''; searchResults.innerHTML = '';
                if (searchViewAll) searchViewAll.style.display = 'none';
                searchClear.style.display = 'none'; searchInput.focus();
            });

            // Delegate add-to-cart inside drawer
            searchResults && searchResults.addEventListener('click', function(e) {
                var btn = e.target.closest('.sr-cart-btn');
                if (btn) addToCart(btn);
            });

            /* =====================================================
               MOBILE GLOBE LANGUAGE BUTTON
            ===================================================== */
            var langBtn  = document.getElementById('langMobileBtn');
            var langDrop = document.getElementById('langMobileDrop');

            langBtn && langBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                langDrop && langDrop.classList.toggle('open');
            });
            document.addEventListener('click', function(e) {
                if (langDrop && !e.target.closest('#langMobileWrap')) {
                    langDrop.classList.remove('open');
                }
            });

            // Scroll to Top Logic
            const scrollTopBtn = document.getElementById('scrollTop');
            window.onscroll = function() {
                if (document.body.scrollTop > 300 || document.documentElement.scrollTop > 300) {
                    scrollTopBtn.classList.add('show');
                } else {
                    scrollTopBtn.classList.remove('show');
                }
            };

            scrollTopBtn.onclick = function() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            };

            @if(session('success'))
                showCartNotification("{{ session('success') }}", 'success');
            @endif

            @if(session('error'))
                showCartNotification("{{ session('error') }}", 'error');
            @endif

            @if($errors->any())
                @foreach($errors->all() as $error)
                    showCartNotification("{{ $error }}", 'error', 5000);
                @endforeach
            @endif
        });
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    @stack('js')
</body>
</html>
