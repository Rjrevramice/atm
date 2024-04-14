<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
	public function __construct(){
        $this->activeTemplate = activeTemplate();
    }

  public function product()
    {
        $pageTitle = "Our Products";
        $emptyMessage = "No Product found";
        $products = Product::where('status', 1)->latest()->paginate(getPaginate());
        return view($this->activeTemplate . 'home', compact('pageTitle', 'emptyMessage', 'products'));
    }

    
     public function getProduct (Request $request)
    {
      //echo 1; exit;
        $pageTitle = "Our Products";
        $emptyMessage = "No Product found";
        $products = Product::where('status',1)->get();
       
           return view('templates.basic.sections.product', compact('pageTitle','emptyMessage','products'));

    }
    public function cart()
    {
        $pageTitle = "Cart Section";
        return view('templates.basic.user.cart',compact('pageTitle'));
    }
  
}

