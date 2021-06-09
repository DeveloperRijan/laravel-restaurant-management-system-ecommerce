<?php

namespace App\Http\Controllers\KS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;

class KsDashboardController extends Controller
{
    public function index(){
        $recentItems = Product::orderBy("created_at", "DESC")->with("get_category")->take(5)->get();
        $recentOrders = Order::orderBy("created_at", "DESC")->take(5)->get();
        return view("ks_panel.dashboard", compact('recentItems', "recentOrders"));
    }
}
