<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use DB;

class OrderController extends Controller
{
	public function __construct(){
        $this->activeTemplate = activeTemplate();
    }
  public function index()
    {
        $oitem = Order::get();
        return view('admin.order.index',compact('oitem'));
    }


  public function getOrder()
  {
    $pageTitle = "All Orders";
    $emptyMessage = "No order Found";
     $order = DB::table('orders')
     ->join('users','users.id','=','orders.user_id')
      ->select('users.username','users.email','users.mobile','orders.*')->orderby('id','desc')
      ->orderBy('orders.id','desc')->paginate(getPaginate(10));

    return view('admin.order.index', compact('pageTitle', 'emptyMessage','order'));
  }

     public function list($id)
     {   
    $pageTitle = "Items - OrderId #$id";
    $emptyMessage = "No order list ";
     $items = DB::table('order_items')
     ->join('products','products.id','=','order_items.product_id')
    ->join('orders','orders.id','=','order_items.order_id')
      ->select('products.name','products.image','products.price','order_items.*','orders.total')
      ->where('order_items.order_id','=',$id)
      ->get();
        return view('admin.order.list', compact('pageTitle', 'emptyMessage','items'));
      
    }
 
  public function changeStatus(Request $request)
    {
        $orders = Order::find($request->id); 
        $orders->status = $request->status; 
        $orders->save(); 
        return response()->json([
      'message' => 'Order status updated Successfully'
  ], 200);
    }

}

