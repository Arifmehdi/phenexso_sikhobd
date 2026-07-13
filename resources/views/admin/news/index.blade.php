@extends('admin.master')
@section('title',"Admin Dashboard | All News")
@section('body')
    <section class="content py-3">
        <div class="row">
            <div class="col-md-11 mx-auto">

                <!-- Top Header Card -->
                <div class="card mb-2 shadow-lg">
                    <div class="card-header- px-2 py-2 d-flex justify-content-between align-items-center">
                        <h3 class="card-title w3-small text-bold text-muted pt-1">
                            <i class="fas fa-sitemap text-primary"></i> News
                        </h3>
                        <a href="{{ route('news.create') }}" class="btn btn-outline-primary btn-xs py-1">
                            <i class="fas fa-plus-square"></i> Add New News
                        </a>
                    </div>
                </div>

                <!-- News Table Card -->
                <div class="card w3-round shadow-lg">
                    <div class="card-header pl-2 py-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="card-title w3-small text-bold text-muted">
                                <i class="fas fa-th text-primary pt-1"></i> All News
                            </h3>

                            <!-- Search Box -->
                            <div class="card-tools">
                                <div class="input-group input-group-sm">
                                    <input type="search" name="q" class="global-search form-control border-right-0 border py-2"
                                        data-url="{{ route('admin.global-search-ajax',['type'=>'post']) }}"
                                        placeholder="Search title, id...">
                                    <div class="input-group-append">
                                        <button type="submit" class="input-group-text bg-transparent">
                                            <i class="fa fa-search w3-text-orange"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body bg-light px-0 pb-0 pt-2">
                        <div class="col-sm-12">
                            <div class="table-responsive data-container">
                                @include('admin.news.search_data')
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection

@push('js')
    <script>
        $( document ).ready(function() {

            $(document).on('change', 'input[name=toogle]', function(){
                var that = $( this );
                var url  = that.attr('data-url');
                var id   = that.val()
                var mode = that.prop('checked');
                $.ajax({
                    url : url,
                    type: "POST",
                    data:{
                        _token:'{{csrf_token()}}',
                        mode:mode,
                        id:id,
                    },
                    success:function(response){
                        if(response.status){
                            alert(response.msg);
                        }
                        else{
                            alert('please try again');
                        }
                    }
                })
            });

            $(document).on('keyup', ".global-search", function(e){

                e.preventDefault();
                var that = $( this );
                var url = that.attr('data-url');
                var q = that.val();
                $.ajax({
                     url: url,
                     data : {q:q},
                     method: "get",
                     success: function(res)
                     {
                        if(res.success)
                        {
                            $(".data-container").empty().append(res.html);
                            $(".data-container input[name=toogle]").bootstrapToggle();
                        }
                     }
                });
            });
        });
    </script>
@endpush
