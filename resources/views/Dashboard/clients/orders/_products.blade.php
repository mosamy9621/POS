<div id="printed_table">
<table  class="table table-bordered table-hover ta text-lg-center table-valign-middle " style="text-align: center" >
    <thead>
    <tr>
        <th style="width: 10px">#</th>
        <th>@lang('site.product')</th>
        <th>@lang('site.quantity')</th>
        <th>@lang('site.price')</th>

    </tr>
    </thead>
    <tbody>
    @foreach($products as $index=> $product)
        <tr>
        <td>{{$index+1}}</td>
        <td>{{$product->name}}</td>
        <td>{{$order->products[$index]->pivot->quantity}}</td>
        <td>{{$order->products[$index]->pivot->price}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
    <p class="text-lg font-weight-bold">@lang('site.total'): {{$order->total_price}}</p>
</div>
<div class="d-flex flex-column align-items-center  ">
    <button class="btn btn-sm btn-success" onclick="printJS('printed_table','html')"><i class="fa fa-print"></i> @lang('site.print')</button>
</div>