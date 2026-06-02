@extends('admin.master')

@section('title', 'View Page Content')

@push('css')
<link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;600;700&display=swap" rel="stylesheet">
<style>
    .bn-font { font-family: 'Hind Siliguri', sans-serif !important; }
    .content-box { border: 1px solid #eee; border-radius: 8px; padding: 20px; background: #fff; height: 100%; }
    .section-title { border-bottom: 2px solid #007bff; padding-bottom: 5px; margin-bottom: 15px; font-weight: 700; color: #333; }
    .meta-card { background: #f8f9fa; border-radius: 6px; padding: 15px; margin-bottom: 15px; border-left: 4px solid #17a2b8; }
</style>
@endpush

@section('body')
    <section class="content py-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="row mb-3 align-items-center">
                        <div class="col-sm-6">
                            <h1 class="h3 m-0">View Details: <span class="text-primary">{{ ucfirst($pageContent->page_slug) }}</span></h1>
                        </div>
                        <div class="col-sm-6 text-right">
                            <a href="{{ route('admin.page_contents.index') }}" class="btn btn-outline-primary btn-sm mr-2"><i class="fas fa-arrow-left mr-1"></i> Back</a>
                            <a href="{{ route('admin.page_contents.edit', $pageContent->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit mr-1"></i> Edit Content</a>
                        </div>
                    </div>

                    <div class="row">
                        <!-- English Content -->
                        <div class="col-md-6 mb-4">
                            <div class="content-box shadow-sm">
                                <h4 class="section-title">English Version</h4>
                                <div class="mb-3">
                                    <label class="text-muted small d-block">Title</label>
                                    <h5 class="font-weight-bold">{!! $pageContent->title_en ?? '<span class="text-muted italic">No Title</span>' !!}</h5>
                                </div>
                                <div class="mb-3">
                                    <label class="text-muted small d-block">Subtitle</label>
                                    <p class="text-dark">{{ $pageContent->subtitle_en ?? 'N/A' }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="text-muted small d-block">Description</label>
                                    <p class="text-dark">{{ $pageContent->description_en ?? 'N/A' }}</p>
                                </div>
                                <hr>
                                <div class="mb-3">
                                    <label class="text-muted small d-block">Main Content Body</label>
                                    <div class="p-3 bg-light rounded" style="max-height: 400px; overflow-y: auto;">
                                        {!! $pageContent->content_en ?? 'N/A' !!}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Bengali Content -->
                        <div class="col-md-6 mb-4">
                            <div class="content-box shadow-sm">
                                <h4 class="section-title">Bengali Version (বাংলা)</h4>
                                <div class="mb-3">
                                    <label class="text-muted small d-block">শিরোনাম</label>
                                    <h5 class="bn-font font-weight-bold">{!! $pageContent->title_bn ?? '<span class="text-muted italic">শিরোনাম নেই</span>' !!}</h5>
                                </div>
                                <div class="mb-3">
                                    <label class="text-muted small d-block">উপ-শিরোনাম</label>
                                    <p class="bn-font text-dark">{{ $pageContent->subtitle_bn ?? 'N/A' }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="text-muted small d-block">বিবরণ</label>
                                    <p class="bn-font text-dark">{{ $pageContent->description_bn ?? 'N/A' }}</p>
                                </div>
                                <hr>
                                <div class="mb-3">
                                    <label class="text-muted small d-block">মূল বিষয়বস্তু</label>
                                    <div class="p-3 bg-light rounded bn-font" style="max-height: 400px; overflow-y: auto;">
                                        {!! $pageContent->content_bn ?? 'N/A' !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Dynamic Sections -->
                    @if($pageContent->page_slug == 'home' && $pageContent->meta)
                    <div class="card card-outline card-info">
                        <div class="card-header">
                            <h3 class="card-title">Home Page Sections (Metadata)</h3>
                        </div>
                        <div class="card-body">
                            
                            <!-- Hero Stats -->
                            @if(isset($pageContent->meta['hero_stats']))
                            <div class="mb-5">
                                <h5 class="font-weight-bold border-bottom pb-2 mb-3"><i class="fas fa-chart-line mr-2"></i> Hero Statistics</h5>
                                <div class="row">
                                    @foreach($pageContent->meta['hero_stats'] as $stat)
                                    <div class="col-md-3">
                                        <div class="meta-card text-center">
                                            <h3 class="text-primary font-weight-bold">{{ $stat['count'] }}</h3>
                                            <div class="small text-muted mb-1">{{ $stat['label_en'] }}</div>
                                            <div class="bn-font text-info">{{ $stat['label_bn'] }}</div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            <!-- How It Works -->
                            @if(isset($pageContent->meta['how_it_works']))
                            <div class="mb-5">
                                <h5 class="font-weight-bold border-bottom pb-2 mb-3"><i class="fas fa-list-ol mr-2"></i> How It Works</h5>
                                <div class="row mb-3">
                                    <div class="col-md-6"><strong>Title (EN):</strong> {{ $pageContent->meta['how_it_works']['title_en'] }}</div>
                                    <div class="col-md-6 bn-font"><strong>শিরোনাম (BN):</strong> {{ $pageContent->meta['how_it_works']['title_bn'] }}</div>
                                </div>
                                <div class="row">
                                    @foreach($pageContent->meta['how_it_works']['steps'] as $step)
                                    <div class="col-md-4">
                                        <div class="meta-card">
                                            <div class="badge badge-primary mb-2">Step {{ $step['num'] }}</div>
                                            <div class="font-weight-bold">{{ $step['title_en'] }}</div>
                                            <div class="bn-font text-primary small mb-2">{{ $step['title_bn'] }}</div>
                                            <p class="small text-muted mb-0">{{ $step['desc_en'] }}</p>
                                            <p class="bn-font small text-dark mb-0 mt-1">{{ $step['desc_bn'] }}</p>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            <!-- Features -->
                            @if(isset($pageContent->meta['features']))
                            <div class="mb-0">
                                <h5 class="font-weight-bold border-bottom pb-2 mb-3"><i class="fas fa-star mr-2"></i> Features (Why SikhoBD?)</h5>
                                <div class="row mb-3">
                                    <div class="col-md-6"><strong>Title (EN):</strong> {{ $pageContent->meta['features']['title_en'] }}</div>
                                    <div class="col-md-6 bn-font"><strong>শিরোনাম (BN):</strong> {{ $pageContent->meta['features']['title_bn'] }}</div>
                                </div>
                                <div class="row">
                                    @foreach($pageContent->meta['features']['items'] as $item)
                                    <div class="col-md-4">
                                        <div class="meta-card">
                                            <div class="text-center mb-2"><i class="{{ $item['icon'] }} fa-2x text-info"></i></div>
                                            <div class="font-weight-bold text-center">{{ $item['title_en'] }}</div>
                                            <div class="bn-font text-primary small text-center mb-2">{{ $item['title_bn'] }}</div>
                                            <p class="small text-muted mb-0">{{ $item['desc_en'] }}</p>
                                            <p class="bn-font small text-dark mb-0 mt-1">{{ $item['desc_bn'] }}</p>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                        </div>
                    </div>
                    @endif

                    <div class="card mt-4">
                        <div class="card-body py-2">
                            <div class="row text-muted small">
                                <div class="col-md-6">Slug: <strong>{{ $pageContent->page_slug }}</strong> | Status: <strong>{{ $pageContent->active ? 'Active' : 'Inactive' }}</strong></div>
                                <div class="col-md-6 text-right">Last Updated: {{ $pageContent->updated_at->format('M d, Y - h:i A') }}</div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
