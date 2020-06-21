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

                            <li class="breadcrumb-item active"><a>@lang('site.add_order')</a></li>

                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="card card-primary">
                <div class="card-header">
                    <h2> @lang('site.add_order')</h2>

                </div>
                <div class="card-body">
                    <div class="container">
                        <div class="row" >
                            <div class="col-md-6 ">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h5> @lang('site.categories')</h5>

                                    </div>
                                    <div class="card-body">
                                        @if($categories->count()>0)
                                        @foreach($categories as $category)
                                           <div>
                                        <a  href="#{{str_replace(' ','-',$category->name)}}" data-toggle="collapse"> <p class="alert alert-default-primary"  >{{$category->name}} <i class="fa fa-plus"></i> </p> </a>
                                               <div class="card  collapse" id="{{str_replace(' ','-',$category->name)}}" >

                                                   <div class="card-body" >

                                                       @if($category->products->count()>0)
                                                       <table  class="table table-responsive text-sm table-valign-middle" style="text-align: center" >
                                                            <thead class="text-xs">
                                                                <tr>
                                                                    <th>@lang('site.name')</th>
                                                                    <th >@lang('site.stock')</th>
                                                                    <th>@lang('site.price')</th>
                                                                    <th>@lang('site.action')</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                       @foreach($category->products as $product)
                                                            <tr>
                                                                <td>{{$product->name}}</td>
                                                                <td id="stock_{{$product->id}}">{{$product->stock}}</td>
                                                                <td>{{$product->selling_price}}</td>
                                                                <td><a href="" class="add-product-btn btn btn-success btn-sm" onclick="product_add(event)" id="product-{{$product->id}}" data-name="{{$product->name}}" data-stock="{{$product->stock}}" data-id="{{$product->id}}" data-price="{{$product->selling_price}}">
                                                                        <span class="fa fa-plus" data-name="{{$product->name}}" data-id="{{$product->id}}" data-stock="{{$product->stock}}" data-price="{{$product->selling_price}}"></span></a></td>

                                                            </tr>


                                                       @endforeach

                                                            </tbody>
                                                        </table>
                                                        @else
                                                           <p>@lang('site.no_info_found')</p>

                                                           @endif
                                                   </div>
                                               </div>
                                           </div>
                                        @endforeach
                                            @else
                                                <p>@lang('site.no_info_found')</p>
                                            @endif
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-6 ">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h5> @lang('site.orders')</h5>
                                    </div>
                                    <div  class="card-body">
                                        <form action="{{route('dashboard.clients.orders.store',$client)}}" method="post">
                                            @csrf
                                            @error('product')
                                            <div class="alert alert-danger alert-dismissible">
                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                                <h5><i class="icon fas fa-ban"></i> @lang('site.alert')!</h5>
                                                <p>*{{$message}}</p>
                                            </div>
                                            @enderror
                                            @error('quantities')
                                            <div class="alert alert-danger alert-dismissible">
                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                                <h5><i class="icon fas fa-ban"></i> @lang('site.alert')!</h5>
                                                <p>*{{$message}}</p>
                                            </div>
                                            @enderror
                                            <table class="table text-sm table-valign-middle " style="text-align: center">
                                                <thead>
                                                <tr>
                                                    <th>@lang('site.product')</th>
                                                    <th>@lang('site.quantity')</th>
                                                    <th>@lang('site.price')</th>
                                                    <th>@lang('site.delete')</th>


                                                </tr>
                                                </thead>
                                                <tbody class="table text-sm table-valign-middle "  id="orders-list">

                                                </tbody>
                                            </table>
                                            <h3 >@lang('site.total'): <span id="total-price" >0</span></h3>
                                            <button type="submit" id="add_order" class="btn btn-info disabled"><i class="fa fa-plus"></i> @lang('site.add_order')</button>
                                        </form>
                                    </div>
                                    </div>

                            </div>

                        </div>
                    </div>

                </div>

            </div>
        </section>
    </div>

@endsection

