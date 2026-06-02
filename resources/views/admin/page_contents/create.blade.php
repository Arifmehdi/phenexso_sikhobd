@extends('admin.master')

@section('title', 'Create Page Content')

@push('css')
<link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;600;700&display=swap" rel="stylesheet">
<style>
    .bn-font { font-family: 'Hind Siliguri', sans-serif !important; }
    .dynamic-card { border: 1px solid #ddd; border-radius: 8px; padding: 15px; margin-bottom: 15px; background: #f9f9f9; position: relative; }
    .remove-btn { position: absolute; top: 10px; right: 10px; color: #dc3545; cursor: pointer; }
    .nav-tabs .nav-link.active { background-color: #28a745; color: white; border-color: #28a745; }
</style>
@endpush

@section('body')
    <section class="content py-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="row mb-3 align-items-center">
                        <div class="col-sm-6">
                            <h1 class="h3 m-0">Create <span class="text-success">New Page Content</span></h1>
                        </div>
                        <div class="col-sm-6 text-right">
                            <a href="{{ route('admin.page_contents.index') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left mr-1"></i> Back to List</a>
                        </div>
                    </div>

                    <form action="{{ route('admin.page_contents.store') }}" method="POST">
                        @csrf
                        
                        <div class="card card-success card-outline card-tabs">
                            <div class="card-header p-0 pt-1 border-bottom-0">
                                <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="tabs-en-tab" data-toggle="pill" href="#tabs-en" role="tab" aria-controls="tabs-en" aria-selected="true">English Content</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="tabs-bn-tab" data-toggle="pill" href="#tabs-bn" role="tab" aria-controls="tabs-bn" aria-selected="false">Bengali Content (বাংলা)</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="tabs-config-tab" data-toggle="pill" href="#tabs-config" role="tab" aria-controls="tabs-config" aria-selected="false">Configuration</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="custom-tabs-three-tabContent">
                                    <!-- English Tab -->
                                    <div class="tab-pane fade show active" id="tabs-en" role="tabpanel" aria-labelledby="tabs-en-tab">
                                        <div class="form-group">
                                            <label for="title_en">Title (English)</label>
                                            <input type="text" name="title_en" id="title_en" class="form-control" value="{{ old('title_en') }}" placeholder="Enter English Title">
                                        </div>
                                        <div class="form-group">
                                            <label for="subtitle_en">Subtitle (English)</label>
                                            <input type="text" name="subtitle_en" id="subtitle_en" class="form-control" value="{{ old('subtitle_en') }}" placeholder="Enter English Subtitle">
                                        </div>
                                        <div class="form-group">
                                            <label for="description_en">Description (English)</label>
                                            <textarea name="description_en" id="description_en" class="form-control" rows="3" placeholder="Enter English Description">{{ old('description_en') }}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="content_en">Full Content (English)</label>
                                            <textarea name="content_en" id="content_en_editor" class="form-control summernote">{{ old('content_en') }}</textarea>
                                        </div>
                                    </div>

                                    <!-- Bengali Tab -->
                                    <div class="tab-pane fade" id="tabs-bn" role="tabpanel" aria-labelledby="tabs-bn-tab">
                                        <div class="form-group">
                                            <label for="title_bn" class="bn-font text-success">শিরোনাম (Bengali)</label>
                                            <input type="text" name="title_bn" id="title_bn" class="form-control bn-font" value="{{ old('title_bn') }}" placeholder="বাংলা শিরোনাম লিখুন">
                                        </div>
                                        <div class="form-group">
                                            <label for="subtitle_bn" class="bn-font text-success">উপ-শিরোনাম (Bengali)</label>
                                            <input type="text" name="subtitle_bn" id="subtitle_bn" class="form-control bn-font" value="{{ old('subtitle_bn') }}" placeholder="বাংলা উপ-শিরোনাম লিখুন">
                                        </div>
                                        <div class="form-group">
                                            <label for="description_bn" class="bn-font text-success">বিবরণ (Bengali)</label>
                                            <textarea name="description_bn" id="description_bn" class="form-control bn-font" rows="3" placeholder="বাংলা বিবরণ লিখুন">{{ old('description_bn') }}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="content_bn" class="bn-font text-success">মূল বিষয়বস্তু (Bengali)</label>
                                            <textarea name="content_bn" id="content_bn_editor" class="form-control summernote bn-font">{{ old('content_bn') }}</textarea>
                                        </div>
                                    </div>

                                    <!-- Config Tab -->
                                    <div class="tab-pane fade" id="tabs-config" role="tabpanel" aria-labelledby="tabs-config-tab">
                                        <div class="form-group">
                                            <label for="page_slug">Page Slug (unique identifier)</label>
                                            <input type="text" name="page_slug" id="page_slug" class="form-control" value="{{ old('page_slug') }}" required placeholder="e.g. services, contact">
                                            <small class="text-muted">Unique URL-friendly name for this content.</small>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="active" name="active" value="1" checked>
                                                <label class="custom-control-label" for="active">Active Status</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Dynamic Meta Sections (Optional for new pages, but ready to add) -->
                        <div class="card card-secondary collapsed-card">
                            <div class="card-header">
                                <h3 class="card-title">Add Advanced Sections (Optional)</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i></button>
                                </div>
                            </div>
                            <div class="card-body" style="display: none;">
                                <p class="text-muted mb-4">Note: These sections are primarily used by the 'home' page layout.</p>
                                
                                <!-- Hero Stats Section -->
                                <div class="mb-5">
                                    <h4 class="border-bottom pb-2 mb-3">Hero Statistics</h4>
                                    <div id="hero-stats-container"></div>
                                    <button type="button" class="btn btn-sm btn-info" onclick="addHeroStat()"><i class="fas fa-plus"></i> Add Stat</button>
                                </div>

                                <!-- How It Works Section -->
                                <div class="mb-5">
                                    <h4 class="border-bottom pb-2 mb-3">How It Works (Steps)</h4>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label>Section Title (EN)</label>
                                            <input type="text" name="meta[how_it_works][title_en]" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="bn-font">বিভাগের শিরোনাম (BN)</label>
                                            <input type="text" name="meta[how_it_works][title_bn]" class="form-control bn-font">
                                        </div>
                                    </div>
                                    <div id="steps-container"></div>
                                    <button type="button" class="btn btn-sm btn-info" onclick="addStep()"><i class="fas fa-plus"></i> Add Step</button>
                                </div>

                                <!-- Features Section -->
                                <div class="mb-3">
                                    <h4 class="border-bottom pb-2 mb-3">Features (Why SikhoBD?)</h4>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label>Features Title (EN)</label>
                                            <input type="text" name="meta[features][title_en]" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="bn-font">বিভাগের শিরোনাম (BN)</label>
                                            <input type="text" name="meta[features][title_bn]" class="form-control bn-font">
                                        </div>
                                    </div>
                                    <div id="features-container"></div>
                                    <button type="button" class="btn btn-sm btn-info" onclick="addFeature()"><i class="fas fa-plus"></i> Add Feature</button>
                                </div>

                            </div>
                        </div>

                        <div class="card-footer bg-white border-top text-right">
                            <button type="submit" class="btn btn-success px-5"><i class="fas fa-check-circle mr-1"></i> Save Page Content</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $('.summernote').summernote({
                height: 200,
                placeholder: 'Write your content here...',
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        });

        function addHeroStat() {
            let container = $('#hero-stats-container');
            let index = container.find('.dynamic-card').length;
            let html = `
                <div class="dynamic-card">
                    <span class="remove-btn" onclick="$(this).parent().remove()"><i class="fas fa-trash"></i></span>
                    <div class="row">
                        <div class="col-md-4">
                            <label>Count</label>
                            <input type="text" name="meta[hero_stats][${index}][count]" class="form-control" placeholder="2.4M+">
                        </div>
                        <div class="col-md-4">
                            <label>Label (EN)</label>
                            <input type="text" name="meta[hero_stats][${index}][label_en]" class="form-control" placeholder="Students">
                        </div>
                        <div class="col-md-4">
                            <label>Label (BN)</label>
                            <input type="text" name="meta[hero_stats][${index}][label_bn]" class="form-control bn-font" placeholder="শিক্ষার্থী">
                        </div>
                    </div>
                </div>
            `;
            container.append(html);
        }

        function addStep() {
            let container = $('#steps-container');
            let index = container.find('.dynamic-card').length;
            let html = `
                <div class="dynamic-card">
                    <span class="remove-btn" onclick="$(this).parent().remove()"><i class="fas fa-trash"></i></span>
                    <div class="row">
                        <div class="col-md-2">
                            <label>Step #</label>
                            <input type="text" name="meta[how_it_works][steps][${index}][num]" class="form-control" placeholder="01">
                        </div>
                        <div class="col-md-5">
                            <label>Title (EN)</label>
                            <input type="text" name="meta[how_it_works][steps][${index}][title_en]" class="form-control">
                            <label class="mt-2">Description (EN)</label>
                            <textarea name="meta[how_it_works][steps][${index}][desc_en]" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="col-md-5">
                            <label class="bn-font">শিরোনাম (BN)</label>
                            <input type="text" name="meta[how_it_works][steps][${index}][title_bn]" class="form-control bn-font">
                            <label class="mt-2 bn-font">বিবরণ (BN)</label>
                            <textarea name="meta[how_it_works][steps][${index}][desc_bn]" class="form-control bn-font" rows="2"></textarea>
                        </div>
                    </div>
                </div>
            `;
            container.append(html);
        }

        function addFeature() {
            let container = $('#features-container');
            let index = container.find('.dynamic-card').length;
            let html = `
                <div class="dynamic-card">
                    <span class="remove-btn" onclick="$(this).parent().remove()"><i class="fas fa-trash"></i></span>
                    <div class="row">
                        <div class="col-md-2">
                            <label>FA Icon</label>
                            <input type="text" name="meta[features][items][${index}][icon]" class="form-control" placeholder="fa-solid fa-star">
                        </div>
                        <div class="col-md-5">
                            <label>Title (EN)</label>
                            <input type="text" name="meta[features][items][${index}][title_en]" class="form-control">
                            <label class="mt-2">Description (EN)</label>
                            <textarea name="meta[features][items][${index}][desc_en]" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="col-md-5">
                            <label class="bn-font">শিরোনাম (BN)</label>
                            <input type="text" name="meta[features][items][${index}][title_bn]" class="form-control bn-font">
                            <label class="mt-2 bn-font">বিবরণ (BN)</label>
                            <textarea name="meta[features][items][${index}][desc_bn]" class="form-control bn-font" rows="2"></textarea>
                        </div>
                    </div>
                </div>
            `;
            container.append(html);
        }
    </script>
@endpush
