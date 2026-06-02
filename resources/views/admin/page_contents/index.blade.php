@extends('admin.master')
@section('title', "Admin Dashboard | Page Contents")

@push('css')
<link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;600;700&display=swap" rel="stylesheet">
<style>
    .bn-font { font-family: 'Hind Siliguri', sans-serif !important; }
</style>
@endpush

@section('body')
    <section class="content py-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Page Contents</h3>
                            <div class="card-tools">
                                <a href="{{ route('admin.page_contents.create') }}" class="btn btn-sm btn-success">
                                    <i class="fas fa-plus mr-1"></i>Add New Page Content
                                </a>
                            </div>
                        </div>

                        <div class="card-body p-0 mb-0">
                          <div class="table-responsive">
                            <table id="example1" class="table table-sm table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th width="20">SL</th>
                                    <th width="100">Action</th>
                                    <th>Page Slug</th>
                                    <th>Title (EN)</th>
                                    <th>Title (BN)</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @php $i = (($pageContents->currentPage() - 1) * $pageContents->perPage() + 1); @endphp

                                    @foreach($pageContents as $content)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>
                                            <div class="dropdown show">
                                                <a class="btn btn-primary btn-xs dropdown-toggle" href="#" role="button" id="dropdownMenuLink{{ $content->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Action
                                                </a>

                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink{{ $content->id }}">
                                                    <a class="dropdown-item" href="{{ route('admin.page_contents.edit', $content->id) }}"><i class="fas fa-edit"></i> Edit</a>
                                                    <a class="dropdown-item" href="{{ route('admin.page_contents.show', $content->id) }}"><i class="fa fa-eye"></i> Show</a>
                                                    <form action="{{ route('admin.page_contents.destroy', $content->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this page content?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger"><i class="fa fa-trash"></i> Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="badge badge-info">{{ ucfirst($content->page_slug) }}</span></td>
                                        <td>{!! $content->title_en !!}</td>
                                        <td class="bn-font">{!! $content->title_bn !!}</td>
                                        <td>
                                            <form action="{{ route('admin.page_contents.toggle-active', $content->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" id="isActiveSwitch{{ $content->id }}" name="active" onchange="this.form.submit()" {{ $content->active ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="isActiveSwitch{{ $content->id }}"></label>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                          </div>
                        </div>

                        <div class="card-footer clearfix">
                            {{ $pageContents->render() }}
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>
@endsection
