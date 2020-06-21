<?php

namespace App\Http\Controllers\Dashboard\Client;

use App\Category;
use App\Client;
use App\Http\Controllers\Controller;
use App\Order;
use App\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Ds\Set;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public  function create(Client $client){
        $this->authorize('CreateOrders',Order::getInstance());
        $categories=Category::all();
        return view('dashboard.clients.orders.create',compact(['categories','client']));
    }

    public function store(Client $client ,Request $request){


        $request->validate([
                'product'=>['required','array'],
                'quantities'=>['required','array'],

        ]);

        // confirming that the user have passed only one product and no more product
        $products_set = new Set();
        foreach ($request->product as $product)
            $products_set->add($product);
        $request->product=$products_set->toArray();
        $products=[];
        $total_quantities=0;
        $total_price=0;
        foreach($request->product as $index=> $product){
            $price=0;
            array_push($products,Product::findOrFail($product));
            $request->validate([
            'quantities'=>['StockValid:1,'.$products[$index]->stock],
            ]);
            $total_quantities+=$request->quantities[$index];
            $products[$index]->stock-=$request->quantities[$index];
            $price=$products[$index]->selling_price*$request->quantities[$index];
            $total_price+=$price;
        }
        $order_param=[
            'client_id'=>$client->id,
            'total_quantity'=>$total_quantities,
            'total_price'=>$total_price
        ];
        $order=Order::create($order_param);
        foreach ($products as $index=>  $product){
            $product->update();
            $order->products()->attach($product,
                ['quantity'=>$request->quantities[$index],
                 'price'=>$product->selling_price,
                ]
            );
        }
        session()->flash('success',__('site.added_successfully'));
        return redirect(route('dashboard.clients.index'));
    }

    public function show(Client $client,Order  $order ,Request $request){

        $this->authorize('ReadOrders',$order);

        $orders=$client->orders();

        if($request->from ||$request->to){
            $request->validate([
                'from'=>['required','date'],
                'to'=>['required','date']
            ]);

            $orders= $orders->whereBetween('created_at',[$request->from,$request->to]);
        }
        $orders=$orders->latest()->paginate(5);
        return(view('dashboard.clients.orders.index',compact(['client','orders'])));


    }

    public function edit(Client $client,Order $order){
        $this->authorize('EditOrders',$order);

        $categories=Category::all();

        return view('dashboard.clients.orders.edit',compact(['categories','client','order']));



    }
    public function  update(Request $request ,Client $client,Order $order){

        $request->validate([
            'product'=>['required','array'],
            'quantities'=>['required','array'],

        ]);

        // confirming that the user have passed only one product and no more product
        $products_set = new Set();
        foreach ($request->product as $product)
            $products_set->add($product);
        $request->product=$products_set->toArray();
        $products=[];
        $total_quantities=0;
        $total_price=0;
        foreach ($order->products as $product){
            $product->stock+=$order->products()
                ->where('product_id',$product->id)->first()->pivot->quantity;
            $order->products()->detach($product);
            $product->save();
        }
        foreach($request->product as $index=> $product){
            $price=0;
            array_push($products,Product::findOrFail($product));
            $request->validate([
                'quantities'=>['StockValid:1,'.$products[$index]->stock],
            ]);
            $total_quantities+=$request->quantities[$index];

            $products[$index]->stock-=$request->quantities[$index];
            $price=$products[$index]->selling_price*$request->quantities[$index];
            $total_price+=$price;
        }

//        $order->total_quantity=$total_quantities;
//        $order->total_price=$total_price;
        $order->update([
            'total_quantity'=>$total_quantities,
            'total_price'=>$total_price
        ]);

        foreach ($products as $index=>  $product){
            $product->update();
            $order->products()->attach($product,
                ['quantity'=>$request->quantities[$index],
                    'price'=>$product->selling_price,
                ]
            );
        }
        session()->flash('success',__('site.edited_successfully'));
        return redirect(route('dashboard.clients.orders.show',[$client,$order]));
    }

    public function destroy(Client $client,Order $order){
        $this->authorize('DeleteOrders',$order);

        $order->delete();
        session()->flash('success',__('site.deleted_successfully'));
        if($client->orders->count()>0)
        return redirect(route('dashboard.clients.orders.show',[$client,$client->orders->first->id]));
        else
            return redirect(route('dashboard.clients.index'));
    }
    public  function product(Client $client,Order $order){
       // dd('i am here');
        //$order=Order::find($order);
        $products=$order->products;
        return view('dashboard.clients.orders._products',compact('order','products'));
    }

    //
}
