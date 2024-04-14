<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CatDetailController extends Controller
{
	public function __construct(){
        $this->activeTemplate = activeTemplate();
    }

 public function show ($id)
    {
        $pageTitle = "Our Products";
        $emptyMessage = "No Product found";
        $product = Product::where('category_id','=',$id)->where('status',1)->get();
       
        return view('templates.basic.sections.category', compact('pageTitle','emptyMessage','product'));
    }
}

