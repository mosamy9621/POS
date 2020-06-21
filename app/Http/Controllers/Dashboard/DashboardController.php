<?php

namespace App\Http\Controllers\Dashboard;

use App\Category;
use App\Http\Controllers\Controller;
use App\Order;
use App\Product;
use App\User;
use App\Client;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){

        $categories_count=Category::on()->count();
        $users_count=User::on()->whereRoleIs('Admin')->count();
        $clients_count=Client::on()->count();
        $orders_count=Order::on()->count();
        $products_count=Product::on()->count();


        return view('Dashboard.index',compact(['categories_count','users_count','clients_count','orders_count','products_count']));

    }


}
