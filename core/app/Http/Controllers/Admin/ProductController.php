<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function create()
    {
        $pageTitle = "Product Create";
       $category = Category::all();
        return view('admin.product.create', compact('pageTitle','category'));
    }

    public function index()
    {
      
      $pageTitle = "All Product List";
    	$emptyMessage = "No data found";
     
      $products  = Product::with('category')->latest()->paginate(5);

         return view('admin.product.index', compact('pageTitle', 'emptyMessage', 'products'));
    }

    public function store(Request $request)
    {
     
       $request->validate([
            'name' => 'required|max:100|unique:products,name', 
            'price' =>'required',
            'size' => 'required',
           // 'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
           $product = new Product();

          $product->name = $request->name;
          $product->category_id = $request->category_id;
          $product->short_description= $request->short_description;
          $product->long_description= $request->long_description;
          $product->material_type= $request->material_type;
          $product->price= $request->price;
          $product->size= $request->size;
          $product->dimension = $request->dimension;

        if ($image = $request->file('image')) {
            $destinationPath = 'assets/images/frontend/product';
            $prodImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $prodImage);
            $product->image = "$prodImage";
       }
          $product->status = $request->status ? 1 : 0;
              $product->save();
     
      return redirect()->route('admin.product.index')
        ->with('success','Product has been created successfully.');
    }

    public function edit($id)
    {
        $products = Product::findOrFail($id);
      $categories = Category::all();
    	$pageTitle = $products->name ." Category Update";
       return view('admin.product.edit', compact('pageTitle', 'products','categories'));
    }

    public function update(Request $request, $id)
    {
         $request->validate([
            'name' => 'required|max:100', 
            'price' =>'required',
            'size' => 'required',
          ]);
        $products = Product::findOrFail($id);
        $products->name = $request->name;
        $products->category_id = $request->category_id;
        $products->short_description= $request->short_description;
        $products->long_description= $request->long_description;
        $products->material_type= $request->material_type;
        $products->dimension = $request->dimension;
        $products->quantity = $request->quantity;
        $products->price = $request->price;
        $products->size = $request->size;
        $products->status = $request->status ? 1 : 0;

        if ($image = $request->file('image')) {
          $destinationPath = 'assets/images/frontend/product';
            $prodImage1 = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $prodImage1);
            $products->image = "$prodImage1";
        }  
         $products->save();

          return redirect()->route('admin.product.index')
              ->with('success','Product has Been updated successfully');
   }
 public function remove(Request $request)
    {
         $request->validate(['id' => 'required']);
         $products = Product::findOrFail($request->id);
         $products->delete();
    	 return redirect()->route('admin.product.index')
                        ->with('success','Product deleted successfully');
    }
}
