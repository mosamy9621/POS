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

                            <li class="breadcrumb-item active"><a>@lang('site.products')</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="card card-primary">
                <div class="card-header">
                    <h2 class="m-0">@lang('site.products')</h2>

                </div>
                <div class="card-body">
                    <form action="{{route('dashboard.products.index')}}"  method="GET" class="row my-2">
                        <div class="col-md-4">
                            <input type="text" name="search" placeholder="@lang('site.search')" class="form-control" value="{{request()->search}}">
                        </div>
                        <div class="col-md-4">
                            <select name ="category" class="form-control select2bs4" style="width: 100%;     scroll-behavior: smooth;" >
                                <option value="" > @lang('site.all_categories')</option>
                            @foreach($categories as $index=> $category)
                                    <option value="{{$category->id}}" {{request('category')==$category->id ? 'selected' : ''}} > {{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <button type="submit" class="btn btn-success"><i class="fa fa-search"></i> @lang('site.search')</button>
                            @if(auth()->user()->hasPermission('create-products'))
                                <a href="{{route('dashboard.products.create')}}" class="btn btn-info "><i class="fa fa-plus"></i> @lang('site.create')</a>
                            @else
                                <a href="#" class="btn btn-info disabled "><i class="fa fa-plus"></i> @lang('site.create')</a>

                            @endif

                        </div>


                    </form>
                    @if($products->count()>0)
                    <table class="table table-bordered table-hover ta text-lg-center table-valign-middle " style="text-align: center" >
                        <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>@lang('site.name')</th>
                            <th>@lang('site.description')</th>
                            <th>@lang('site.purchased_price')</th>
                            <th>@lang('site.selling_price')</th>
                            <th>@lang('site.stock')</th>
                            <th>@lang('site.profit_percentage')</th>
                            <th>@lang('site.image')</th>
                            <th>@lang('site.category')</th>
                            <th>@lang('site.action')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($products as $index=>$product)
                            <tr>
                                <td>{{$index+1}}</td>
                                <td>{{$product->name}}</td>
                                <td>{{$product->description}}</td>
                                <td>{{$product->purchased_price}}</td>
                                <td>{{$product->selling_price}}</td>
                                <td>{{$product->stock}}</td>
                                <td>{{$product->profit_percentage}} %</td>
                                <td><img src="{{$product->ImagePath}}" style="width: 100px; height: 100px;"></td>
                                <td>{{$product->category->name}}</td>

                                <td>
                                    @can('EditProducts',$product)

                                        <a class="btn mb-sm-1 btn-primary" href="{{route('dashboard.products.edit',$product)}}"> <i class="fa fa-edit"></i>@lang('site.edit')</a>
                                    @else
                                        <a class="btn mb-sm-1 btn-primary disabled" >@lang('site.edit')</a>
                                    @endcan
                                    @can('DeleteProducts',$product)
                                    <form id="delete_submit" style="display: inline-block" action="{{route('dashboard.products.destroy',$product)}}" method="POST" >
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn mb-sm-1 btn-danger" onclick="deleteConfirm(event)"><i class="fa fa-trash"></i> @lang('site.delete')</button>

                                    </form>
                                     @else
                                            <button type="submit" class="btn mb-sm-1 btn-danger disabled"><i class="fa fa-trash"></i> @lang('site.delete')</button>

                                        @endcan

                                </td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                        {{$products->appends(request()->query())->links()}}
                    @else
                        <h3>@lang('site.no_info_found')</h3>
                    @endif
                </div>

            </div>


       </section>
    </div>
    <script src="{{asset('js/noty.js')}}" type="text/javascript"></script>
    <script>
       var sidebar =  document.createAttribute('class');
       sidebar.value='container-fluid sidebar-mini layout-fixed sidebar-collapse';
       document.body.setAttributeNode(sidebar);
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