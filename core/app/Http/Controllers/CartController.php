<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use DB;

class CartController extends Controller
{
	public function __construct(){
        $this->activeTemplate = activeTemplate();
    }

public function store(Request $request)
  {
    $product_id = $request->product_id;
    $user_id = $request->user_id;
    $quantity = $request->quantity;

    //check for existing product in cart
    $getCart = Cart::where('product_id','=',$product_id)->where('user_id','=',$user_id)->first();
    if($getCart){
      $getQuantity = $getCart->quantity;
      $getCart->quantity = $getQuantity + $quantity;
      $getCart->save();
      
      return response()->json([
        'message' => 'Updated The Cart Successfully'
    ], 200);

    }else{
      Cart::create($request->all());
      return response()->json([
        'message' => 'Added To Cart Successfully'
    ], 200);
    } 
  }
  public function cartStore(Request $request)
  {
    $cart_id=$request->cart_id;
    $quantity=$request->quantity;

      //check for existing product in cart
      $getCart = Cart::where('id','=',$cart_id)->first();
      $getCart->quantity =  $quantity;
      $getCart->save();
      
      return response()->json([
        'message' => 'Updated The Cart Successfully'
    ], 200);

  }
  public function updateCheckout(Request $request){

      $saveOrder = Order::create($request->all());
      $orderId = $saveOrder->id;
      //update orderitmes and clear cart items
      Cart::query()
      ->where('user_id',$request->user_id)
      ->each(function ($oldRecord) use($orderId) {
        $newRecord = $oldRecord->replicate();
        $newRecord->setTable('order_items');
        $newRecord->order_id = $orderId;
        $newRecord->save();
        //delete cart items
        $oldRecord->delete();
      });
      return response()->json([
        'message' => 'Order Placed Successfully'
    ], 200);
  }

    public function cartList()
    {

      $pageTitle = "My Cart";
      $cartItems = DB::table('carts')
            ->join('products', 'products.id', '=', 'carts.product_id')
             ->select('carts.*','carts.quantity', 'products.name', 'products.price')->where('user_id',Auth::user()->id)
            ->get();

      return view('templates.basic.user.cart',compact('pageTitle','cartItems'));
    }

    public function cartDelete(Request $request){
        if($request->cart_id) {
          Cart::where('id', '=', $request->cart_id)->delete();
      }
    }
}

