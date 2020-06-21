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

                            <li class="breadcrumb-item active"><a>@lang('site.clients')</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="card card-primary">
                <div class="card-header">
                    <h2 class="m-0">@lang('site.clients')</h2>

                </div>
                <div class="card-body">
                    <form action="{{route('dashboard.clients.index')}}"  method="GET" class="row my-2">
                        <div class="col-md-4">
                            <input type="text" name="search" placeholder="@lang('site.search')" class="form-control" value="{{request()->search}}">
                        </div>

                        <div class="col-md-4">
                            <button type="submit" class="btn btn-success"><i class="fa fa-search"></i> @lang('site.search')</button>
                            @if(auth()->user()->hasPermission('create-clients'))
                                <a href="{{route('dashboard.clients.create')}}" class="btn btn-info "><i class="fa fa-plus"></i> @lang('site.create')</a>
                            @else
                                <a href="#" class="btn btn-info disabled "><i class="fa fa-plus"></i> @lang('site.create')</a>

                            @endif

                        </div>


                    </form>
                    @if($clients->count()>0)
                    <table class="table table-bordered table-hover ta text-lg-center table-valign-middle " style="text-align: center" >
                        <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>@lang('site.name')</th>
                            <th>@lang('site.address')</th>
                            <th>@lang('site.phone')</th>
                            <th>@lang('site.orders')</th>
                            <th>@lang('site.orders_no')</th>

                            <th>@lang('site.action')</th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($clients as $index=>$client)
                            <tr>
                                <td>{{$index+1}}</td>
                                <td>{{$client->name}}</td>
                                <td>{{$client->address}}</td>
                                <td>{{$client->phone}}</td>

                                <td class="" >
                                    @if(auth()->user()->hasPermission('create-orders'))
                                        <a href="{{route('dashboard.clients.orders.create',$client)}}" class="my-1 btn btn-primary btn-sm"><i class="fa fa-plus"></i> @lang('site.add_order')</a>
                                        @if($client->orders->count()>0)

                                            <a href="{{route('dashboard.clients.orders.show',[$client,$client->orders->first->id])}}" class="my-1  btn btn-primary btn-sm"><i class="fa fa-info"></i> @lang('site.show_order')</a>
                                        @else
                                            <a href="" class="my-1 btn btn-primary btn-sm disabled"><i class="fa fa-info"></i> @lang('site.show_order')</a>
                                        @endif

                                    @else

                                        <a href="" class="my-1 btn btn-primary btn-sm disabled"><i class="fa fa-plus"></i> @lang('site.add_order')</a>
                                    @endif
                                </td>
                                <td>{{$client->orders()->count()}}</td>
                                    <td>
                                    @can('EditClients',$client)

                                        <a class="btn btn-primary btn-sm my-1" href="{{route('dashboard.clients.edit',$client)}}"> <i class="fa fa-edit"></i>@lang('site.edit')</a>
                                    @else
                                        <a class="btn btn-primary btn-sm my-1 disabled" >@lang('site.edit')</a>
                                    @endcan
                                    @can('DeleteClients',$client)
                                    <form id="delete_submit" style="display: inline-block" action="{{route('dashboard.clients.destroy',$client)}}" method="POST" >
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm my-1 btn-danger" onclick="deleteConfirm(event)"><i class="fa fa-trash"></i> @lang('site.delete')</button>

                                    </form>
                                     @else
                                            <button type="submit" class="btn btn-sm my-1 btn-danger disabled"><i class="fa fa-trash"></i> @lang('site.delete')</button>

                                        @endcan

                                </td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                        {{$clients->appends(request()->query())->links()}}
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