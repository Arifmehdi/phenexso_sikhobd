@extends('website.layouts.sikhobd')

@section('title', ($ebook->title_bn ?? $ebook->title_en) . ' — Reader')

@push('css')
<style>
    .reader-wrap { background: #334155; min-height: 100vh; padding: 0 0 40px; }
    .reader-toolbar {
        position: sticky; top: 0; z-index: 50;
        background: #1e293b; color: #fff;
        display: flex; align-items: center; justify-content: space-between;
        gap: 12px; padding: 12px 20px; flex-wrap: wrap;
        box-shadow: 0 2px 10px rgba(0,0,0,0.3);
    }
    .reader-toolbar .tb-title { font-weight: 700; font-size: 15px; max-width: 40%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .reader-toolbar .tb-actions { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
    .tb-btn {
        background: rgba(255,255,255,0.1); color: #fff; border: 1px solid rgba(255,255,255,0.15);
        border-radius: 8px; padding: 7px 14px; font-size: 13px; font-weight: 600; cursor: pointer;
        display: inline-flex; align-items: center; gap: 6px; text-decoration: none; transition: all .2s;
    }
    .tb-btn:hover { background: rgba(255,255,255,0.2); color: #fff; }
    .tb-btn.primary { background: var(--accent); border-color: var(--accent); }
    .tb-btn.primary:hover { background: #fff; color: var(--accent); }

    #pdf-pages { max-width: 920px; margin: 24px auto; padding: 0 12px; }
    #pdf-pages canvas {
        display: block; margin: 0 auto 18px; width: 100%; height: auto;
        box-shadow: 0 6px 24px rgba(0,0,0,0.4); border-radius: 4px; background: #fff;
        -webkit-user-select: none; user-select: none; -webkit-user-drag: none;
    }
    #reader-status { text-align: center; color: #cbd5e1; padding: 40px 0; }

    .preview-cta {
        max-width: 760px; margin: 10px auto 0; background: #fff; border-radius: 16px;
        padding: 30px; text-align: center; box-shadow: 0 8px 30px rgba(0,0,0,0.25);
    }
    .preview-cta h3 { font-weight: 800; color: #1e293b; margin-bottom: 8px; }
    .preview-cta p { color: #64748b; margin-bottom: 18px; }

    /* Print: only the pages, nothing else */
    @media print {
        body * { visibility: hidden; }
        #pdf-pages, #pdf-pages * { visibility: visible; }
        #pdf-pages { position: absolute; left: 0; top: 0; margin: 0; max-width: 100%; }
        #pdf-pages canvas { box-shadow: none; page-break-after: always; margin: 0; }
        .reader-toolbar, .preview-cta { display: none !important; }
    }
</style>
@endpush

@section('content')
<div class="reader-wrap" oncontextmenu="return false;">
    <div class="reader-toolbar">
        <div class="tb-title"><i class="fa-solid fa-book-open mr-2"></i>{{ $ebook->title_bn ?? $ebook->title_en }}</div>
        <div class="tb-actions">
            <button class="tb-btn" onclick="zoomReader(-0.15)"><i class="fa-solid fa-magnifying-glass-minus"></i></button>
            <button class="tb-btn" onclick="zoomReader(0.15)"><i class="fa-solid fa-magnifying-glass-plus"></i></button>
            <button class="tb-btn" onclick="window.print()"><i class="fa-solid fa-print"></i> Print</button>
            @if($canDownload)
                <a class="tb-btn primary" href="{{ $downloadUrl }}"><i class="fa-solid fa-download"></i> Download</a>
            @endif
            <a class="tb-btn" href="{{ route('ebooks.show', $ebook->id) }}"><i class="fa-solid fa-arrow-left"></i> Back</a>
        </div>
    </div>

    @if($isPreview)
        <div style="text-align:center; color:#fde68a; padding:14px; font-weight:600;">
            <i class="fa-solid fa-circle-info"></i>
            {{ app()->getLocale() == 'bn'
                ? 'এটি একটি প্রিভিউ — মাত্র ' . $maxPages . ' পৃষ্ঠা দেখানো হচ্ছে। সম্পূর্ণ বই পড়তে কিনুন।'
                : 'Preview only — showing first ' . $maxPages . ' page(s). Purchase to read the full book.' }}
        </div>
    @endif

    <div id="pdf-pages"></div>
    <div id="reader-status"><i class="fa-solid fa-spinner fa-spin fa-2x"></i><p class="mt-3">Loading book…</p></div>

    @if($isPreview)
        <div class="preview-cta">
            <h3>{{ app()->getLocale() == 'bn' ? 'সম্পূর্ণ বইটি পড়তে চান?' : 'Want to read the full book?' }}</h3>
            <p>{{ app()->getLocale() == 'bn' ? 'বইটি কিনে সব পৃষ্ঠা পড়ুন এবং প্রিন্ট করুন।' : 'Buy this eBook to read & print all pages.' }}</p>
            <a href="{{ route('ebooks.buy', $ebook->id) }}" class="btn btn-accent" style="padding:12px 28px; border-radius:10px; font-weight:700;">
                <i class="fa-solid fa-cart-shopping mr-1"></i> {{ app()->getLocale() == 'bn' ? 'এখনই কিনুন' : 'Buy Now' }}
            </a>
        </div>
    @endif
</div>
@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
<script>
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

    const PDF_URL  = @json($pdfUrl);
    const MAX_PAGES = {{ $maxPages ? (int) $maxPages : 'null' }};
    let pdfDoc = null;
    let scale = 1.3;
    let renderedPages = 0;

    function renderPage(num) {
        return pdfDoc.getPage(num).then(function(page) {
            const viewport = page.getViewport({ scale: scale });
            const canvas = document.createElement('canvas');
            canvas.id = 'page-' + num;
            const ctx = canvas.getContext('2d');
            const ratio = window.devicePixelRatio || 1;
            canvas.width = viewport.width * ratio;
            canvas.height = viewport.height * ratio;
            canvas.style.maxWidth = viewport.width + 'px';
            ctx.scale(ratio, ratio);
            document.getElementById('pdf-pages').appendChild(canvas);
            return page.render({ canvasContext: ctx, viewport: viewport }).promise;
        });
    }

    function renderAll() {
        document.getElementById('pdf-pages').innerHTML = '';
        const total = pdfDoc.numPages;
        const limit = MAX_PAGES ? Math.min(MAX_PAGES, total) : total;
        renderedPages = limit;
        let chain = Promise.resolve();
        for (let i = 1; i <= limit; i++) {
            chain = chain.then(() => renderPage(i));
        }
        return chain;
    }

    function loadPdf() {
        document.getElementById('reader-status').style.display = 'block';
        pdfjsLib.getDocument(PDF_URL).promise.then(function(pdf) {
            pdfDoc = pdf;
            return renderAll();
        }).then(function() {
            document.getElementById('reader-status').style.display = 'none';
        }).catch(function(err) {
            document.getElementById('reader-status').innerHTML =
                '<p style="color:#fca5a5;">Could not load this book. Please try again later.</p>';
            console.error(err);
        });
    }

    let zoomTimer = null;
    function zoomReader(delta) {
        scale = Math.min(2.5, Math.max(0.6, scale + delta));
        document.getElementById('reader-status').style.display = 'block';
        clearTimeout(zoomTimer);
        zoomTimer = setTimeout(() => {
            renderAll().then(() => { document.getElementById('reader-status').style.display = 'none'; });
        }, 150);
    }

    document.addEventListener('DOMContentLoaded', loadPdf);
</script>
@endpush
