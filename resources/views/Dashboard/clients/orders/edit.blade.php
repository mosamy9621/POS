@extends('Dashboard.layouts.app')
@section('content')
    <div class="content-wrapper"  >
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item "><a href="{{route('dashboard.index')}}">@lang('site.dashboard')</a></li>
                            <li class="breadcrumb-item "><a href="{{route('dashboard.clients.index')}}">@lang('site.clients')</a></li>

                            <li class="breadcrumb-item active"><a>@lang('site.edit_order')</a></li>

                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="card card-primary">
                <div class="card-header">
                    <h2> @lang('site.edit_order')</h2>

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
                                                    <div class="card

                                                     {{in_array($category->id,$order->products->pluck('category_id')->unique()->toArray()) ? '':'collapse'}}

                                                     " id="{{str_replace(' ','-',$category->name)}}" >

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
                                                                            <td><a href="" class="add-product-btn btn {{in_array($product->id,$order->products->pluck('id')->toArray()) ? 'btn-default disabled' :'btn-success'}}  btn-sm" onclick="product_add(event)" id="product-{{$product->id}}" data-name="{{$product->name}}" data-stock="{{$product->stock}}" data-id="{{$product->id}}" data-price="{{$product->selling_price}}">
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
                                        <form action="{{route('dashboard.clients.orders.update',[$client,$order])}}" method="post">
                                            @csrf
                                            @method('PUT')
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
                                                @foreach($order->products as $product)
                                                    <tr id="product_{{$product->id}}">
                                                        <td>{{$product->name}}</td>
                                                        <td>
                                                            <input  type="number" name="quantities[]"
                                                                   onchange="update_total(event)" data-id="{{$product->id}}"
                                                                   data-price="{{$product->pivot->price}}" max="{{$product->max}}"
                                                                   id="quantity-{{$product->id}}" style="text-align: center; width:75%;"
                                                                   value="{{$product->pivot->quantity}}" min="1" class="quantity">
                                                        </td>
                                                        <td id="price_{{$product->id}}">{{$product->pivot->price*$product->pivot->quantity}}</td>
                                                        <td><a class="btn btn-danger" onclick="product_remove(event);update_total(event);"  data-price="{{$product->pivot->price}}" data-id="{{$product->id}}" href="#"><i class="fa fa-trash"></i></a></td>
                                                        <input type="hidden" name="product[]" value="{{$product->id}}">
                                                    </tr>

                                                @endforeach

                                                </tbody>
                                            </table>
                                            <h3 >@lang('site.total'): <span id="total-price" >0</span></h3>
                                            <button type="submit" id="add_order" class="btn btn-info "><i class="fa fa-edit"></i> @lang('site.edit_order')</button>
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
    <script>



        var quantities= document.getElementsByClassName("quantity");
        let edit_total_price=0.00;

        function show_eddited_total() {
            let element= document.getElementById('total-price');
            element.innerHTML=edit_total_price.toFixed(2);


        }


        for (var i =0;i<quantities.length;i++){
            var id =quantities[i].dataset.id;
            edit_total_price+=parseFloat(parseFloat(quantities[i].dataset.price)*parseInt(quantities[i].value));
            var stock=document.getElementById('stock_'+id);
            stock.innerHTML=parseInt(stock.innerHTML)+parseInt(quantities[i].value)
        }

        show_eddited_total();
    </script>

@endsection


