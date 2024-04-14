<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use DB;

class OrderController extends Controller
{
	public function __construct(){
        $this->activeTemplate = activeTemplate();
    }

    public function index()
        {
        $pageTitle = "My Orders";
        $user = Auth::user();
        return view($this->activeTemplate. 'templates.basic.user.order', compact('pageTitle','user'));
        }

 public function view()
    {

      $pageTitle = "My Orders";
      $emptyMessage = "No Order Placed";
      $items = DB::table('orders')
            ->join('users','users.id','=','orders.user_id')
            ->select('orders.*','users.username', 'users.mobile', 'users.email')->where('user_id',Auth::user()->id)
            ->orderBy('orders.id','desc')->paginate(getPaginate(10));
     return view('templates.basic.user.order',compact('pageTitle','emptyMessage','items'));
    }

 public function list($id)
    {
      $pageTitle = "Items - OrderId #$id";
      $emptyMessage = "No Item Placed";
      $itemlist = DB::table('order_items')
            ->join('products','products.id','=','order_items.product_id')
            ->join('orders','orders.id','=','order_items.order_id')
            ->select('order_items.*','products.name', 
              'products.image','products.price','orders.total')->where('order_items.order_id','=',$id)
            ->get();

      return view('templates.basic.user.item',compact('pageTitle','emptyMessage','itemlist'));
    }


}

