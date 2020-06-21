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
                            <li class="breadcrumb-item "><a href="{{route('dashboard.clients.index')}}">@lang('site.clients')</a></li>

                            <li class="breadcrumb-item active"><a>@lang('site.clients_order')</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content row ">
                <div class="card card-primary col-md-8">
                    <div class="card-header">

                    </div>
                    <div class=" card-body text-sm">
                        <h5 class="m-0">@lang('site.clients_order')</h5>

                        <form action="{{route('dashboard.clients.orders.show',[$client,$client->id])}}"  method="GET" class="row align-items-end my-2">
                            <div class="col-md-1">

                                <label class="text-xs" for="from">@lang('site.from'):</label>

                            </div>
                            <div class="col-md-3 align-middle">
                                @error('from')
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <h5><i class="icon fas fa-ban"></i> @lang('site.alert')!</h5>
                                    <p>*{{$message}}</p>
                                </div>
                                @enderror
                                <input type="datetime-local" name="from"  class="form-control" value="{{request()->from}}">

                            </div>
                            <div class="col-md-1">
                                <label class="text-xs"  for="to">@lang('site.to'):</label>
                            </div>
                            <div class="col-md-3 align-middle">
                                @error('to')
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <h5><i class="icon fas fa-ban"></i> @lang('site.alert')!</h5>
                                    <p>*{{$message}}</p>
                                </div>
                                @enderror
                                <input type="datetime-local" name="to" placeholder="@lang('site.search')" class="form-control" value="{{request()->to}}">
                            </div>

                            <div class="col-md-2">
                                <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-search"></i> @lang('site.search_with_date')</button>
                            </div>
                            <div class="col-md-2">
                                <a href="{{route('dashboard.clients.orders.show',[$client,$client->id])}}" class="btn text-sm font-weight-bold btn-sm btn-warning"><i class="fa fa-refresh"></i> @lang('site.show_all')</a>
                            </div>

                        </form>
                        @if($orders->count()>0)
                            <table class="table table-bordered table-hover ta text-lg-center table-valign-middle " style="text-align: center" >
                                <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>@lang('site.client_name')</th>
                                    <th>@lang('site.total_quantity')</th>
                                    <th>@lang('site.created_at')</th>
                                    <th>@lang('site.total_price')</th>

                                    <th>@lang('site.action')</th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach($orders as $index=> $order)
                                    <tr>
                                    <td>{{$index+1}}</td>
                                    <td>{{$client->name}}</td>
                                    <td>{{$order->total_quantity}}</td>
                                    <td>{{$order->created_at->toFormattedDateString()}}</td>

                                    <td>{{$order->total_price}}</td>
                                    <td>
                                        @can('EditOrders',$order)

                                            <a class="btn btn-sm btn-primary my-1" href="{{route('dashboard.clients.orders.edit',[$client,$order])}}"> <i class="fa fa-edit"></i>@lang('site.edit')</a>
                                        @else
                                            <a class="btn btn-sm btn-primary my-1 disabled" >@lang('site.edit')</a>
                                        @endcan
                                        @can('DeleteOrders',$order)
                                            <form id="delete_submit" style="display: inline-block" action="{{route('dashboard.clients.orders.destroy',[$client,$order])}}" method="POST" >
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm my-1 btn-danger" onclick="deleteConfirm(event)"><i class="fa fa-trash"></i> @lang('site.delete')</button>

                                            </form>
                                        @else
                                            <button type="submit" class="btn btn-sm my-1 btn-danger disabled"><i class="fa fa-trash"></i> @lang('site.delete')</button>

                                        @endcan
                                            @can('ReadOrders',$order)
                                            <a   id="show_products_{{$order->id}}" onClick="show_products(event)" data-method="GET" data-id="{{$order->id}}" data-url="{{route('dashboard.clients.orders.product',[$client,$order])}}" class="btn btn-sm my-1 btn-warning font-weight-bold" ><i data-id="{{$order->id}}" class="fa fa-bars"></i> @lang('site.product_show')</a>

                                            @else
                                                <a  class="btn btn-sm my-1 btn-warning disabled font-weight-bold" onclick=""><i class="fa fa-bars"></i> @lang('site.product_show')</a>

                                            @endcan

                                    </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{$orders->appends(request()->query())->links()}}
                        @else
                            <h3>@lang('site.no_info_found')</h3>
                        @endif
                    </div>


                </div>
            <div class="card card-primary col-md-4">
                <div class="card-header">

                </div>
                <div class=" card-body text-sm">
                    <h5 class="m-0">@lang('site.product_show')</h5>
                    <div id="show_data"></div>


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