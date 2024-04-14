<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function create()
    {
        $pageTitle = "Create Category";
        return view('admin.category.create', compact('pageTitle'));
    }

    public function index()
    {
   
        $pageTitle = "Help List";
    	$emptyMessage = "No data found";

        $categories  = Category::orderBy('id','desc')->paginate(5);
        return view('admin.category.index', compact('pageTitle', 'emptyMessage', 'categories'));
    }

    public function store(Request $request)
    {
     
       $request->validate([
             'name' => 'required|max:100|unique:categories,name', 
       ]);
        
        $categories = new Category();
           
        $categories->name = $request->name;

       if ($image = $request->file('image')) {
            $destinationPath = 'assets/images/frontend/category';
            $catImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $catImage);
            $categories->image = "$catImage";
        }

        $categories->save();
        return redirect()->route('admin.category.index')
        ->with('success','Category has been created successfully.');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
    	$pageTitle = $category->name ." Category Update";
       return view('admin.category.edit', compact('pageTitle', 'category'));
    }

    public function update(Request $request, $id)
    {
         $request->validate([
            'name' => 'required|max:100', 
          ]);
        
        $categories = new Category();
        $categories = Category::findOrFail($id);
        $categories->name = $request->name;

        if ($image = $request->file('image')) {
            $destinationPath = 'assets/images/frontend/category';
            $catImage1 = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $catImage1);
            $categories->image = "$catImage1";
         
        }
        $categories->save();
        return redirect()->route('admin.category.index')
        ->with('success','Category has Been updated successfully');
    }

  public function remove(Request $request)
         {
            $products = Product::where('category_id',Input::get('id'))->count();
            if($products > 0)
            {
            return Redirect::to('admin.category.index')->with('message','something went wrong');
            }
        else{
            $request->validate(['id' => 'required']);
            $category = Category::findOrFail($request->id);
            $category->delete();
             return redirect()->route('admin.category.index')
             ->with('success','Category deleted successfully');
            }
         }
}
