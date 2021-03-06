@extends('Dashboard.layouts.app')
@section('content')
    <div class="content-wrapper" >
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item "><a href="{{route('dashboard.index')}}">@lang('site.dashboard')</a></li>

                            <li class="breadcrumb-item active"><a>@lang('site.categories')</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="card card-primary">
                <div class="card-header">
                    <h2 class="m-0">@lang('site.categories')</h2>

                </div>
                <div class="card-body">
                    <form action="{{route('dashboard.categories.index')}}"  method="GET" class="row my-2">
                        <div class="col-md-4">
                            <input type="text" name="search" placeholder="@lang('site.search')" class="form-control" value="{{request()->search}}">
                        </div>

                        <div class="col-md-4">
                            <button type="submit" class="btn btn-success"><i class="fa fa-search"></i> @lang('site.search')</button>
                            @if(auth()->user()->hasPermission('create-categories'))
                                <a href="{{route('dashboard.categories.create')}}" class="btn btn-info "><i class="fa fa-plus"></i> @lang('site.create')</a>
                            @else
                                <a href="#" class="btn btn-info disabled "><i class="fa fa-plus"></i> @lang('site.create')</a>

                            @endif

                        </div>


                    </form>
                    @if($categories->count()>0)
                    <table class="table table-bordered table-hover ta text-lg-center table-valign-middle " style="text-align: center" >
                        <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>@lang('site.name')</th>
                            <th>@lang('site.products_no')</th>
                            <th>@lang('site.products_link')</th>
                            <th>@lang('site.action')</th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($categories as $index=>$category)
                            <tr>
                                <td>{{$index+1}}</td>
                                <td>{{$category->name}}</td>
                                <td>{{$category->products->count()}}</td>
                                <td><a class="btn btn-primary" href="{{route('dashboard.products.index',['category'=>$category->id])}}">@lang('site.products_link')</a></td>
                                <td>
                                    @can('EditCategories',$category)

                                        <a class="btn btn-primary" href="{{route('dashboard.categories.edit',$category)}}"> <i class="fa fa-edit"></i>@lang('site.edit')</a>
                                    @else
                                        <a class="btn btn-primary disabled" >@lang('site.edit')</a>
                                    @endcan
                                    @can('DeleteCategories',$category)
                                    <form id="delete_submit" style="display: inline-block" action="{{route('dashboard.categories.destroy',$category)}}" method="POST" >
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="deleteConfirm(event)"><i class="fa fa-trash"></i> @lang('site.delete')</button>

                                    </form>
                                     @else
                                            <button type="submit" class="btn btn-danger disabled"><i class="fa fa-trash"></i> @lang('site.delete')</button>

                                        @endcan

                                </td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                        {{$categories->appends(request()->query())->links()}}
                    @else
                        <h3>@lang('site.no_info_found')</h3>
                    @endif
                </div>

            </div>


       </section>
    </div>
    <script src="{{asset('js/noty.js')}}" type="text/javascript"></script>
    <script>
        function  deleteConfirm(event) {
            event.preventDefault();
            var element = document.getElementById('delete_submit');
            var n = new Noty({
                type: 'warning',
                layout: 'topRight',
                text: "@lang('site.confirm_delete')",
                killer:true,
                buttons:[
                    Noty.button('@lang('site.confirm_yes')','btn btn-success',function () {
                      element.submit();
                    }),
                    Noty.button('@lang('site.confirm_no')','btn btn-danger mx-2',function () {
                       n.close();
                    })
                ]
            }).show();
        }

    </script>
@endsection