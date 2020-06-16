<?php

namespace App\Http\Controllers\Dashboard\Client;

use App\Category;
use App\Client;
use App\Http\Controllers\Controller;
use App\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public  function create(Client $client){
        $this->authorize('CreateOrders',Order::getInstance());
        $categories=Category::paginate(7);
        return view('dashboard.clients.orders.create',compact(['categories','client']));
    }

    public function store(Client $client ,Request $request){

        dd($request->all());
    }
    //
}
