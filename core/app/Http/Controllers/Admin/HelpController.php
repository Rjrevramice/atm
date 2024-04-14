<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Help;
use App\Models\WebTasks;
use App\Models\WebTasksSubmissions;

class HelpController extends Controller
{

    public function provide_help(){
        $pageTitle = "Provide Help List";
        $provideHelp = Help::where('help_type','provide_help')->with('user')->orderBy('id','desc')->paginate(5);
        return view('admin.helps.provide_help',compact('provideHelp','pageTitle'));
    }
    public function get_help(){
        $pageTitle = "Get Help List";
        $provideHelp = Help::where('help_type','get_help')->with('user')->orderBy('id','desc')->paginate(5);
        return view('admin.helps.get_help',compact('provideHelp','pageTitle'));
    }
    public function provide_help_edit($id){
        $pageTitle = "Update Provide Help";
        $provideHelp = Help::where('id',$id)->where('help_type','provide_help')->with('user')->first();
        $getHelp = Help::where('help_type','get_help')->with('user')->get();
        return view ('admin.helps.provide_help_edit',compact('provideHelp','pageTitle','getHelp'));
    }
    public function get_help_edit($id){
        $pageTitle = "Update Get     Help";
        $getHelp = Help::where('id',$id)->where('help_type','get_help')->with('user')->first();
        $provideHelp = Help::where('help_type','provide_help')->with('user')->get();
        return view ('admin.helps.get_help_edit',compact('provideHelp','pageTitle','getHelp'));
    }
    public function provide_help_update($id, Request $request){
       $help =  Help::where('id',$id)->first();
       $help->currency = $request->currency;
       $help->amount = $request->amount;
       if($request->get_help){
        $help->match_id = implode(',',$request->get_help);
       }
       
       if($request->block_user){
        $help->status = 0;
       }
       $help->save();
       $notify[] = ['success', 'Ticket assigned successfully'];
       return back()->withNotify($notify);
    }
    public function get_help_update($id, Request $request){
        $help =  Help::where('id',$id)->first();
        $help->currency = $request->currency;
        $help->amount = $request->amount;
        $help->match_id = $request->provide_help;
        if($request->block_user){
            $help->status = 0;
        }
        $help->save();
        $notify[] = ['success', 'Ticket assigned successfully'];
        return back()->withNotify($notify);
    }
    public function save_get_help(){
        $this->validate($request, [
            'currency' => 'required',
            'amount' => 'required|numeric',
        ]);
        $help = new Help;
        $help->currency = $request->currency;
        $help->amount = $request->amount;
        $help->user_id = auth()->id();
        $help->current_token =rand(1000000,9999999);
        $help->help_type = "get_help";
        $help->save();
        $notify[] = ['success', 'Your Get Help Ticket is Raised'];
        return back()->withNotify($notify);
    }
    public function webTasksUploads(){
        $pageTitle = "Upload Task Link";
    	$emptyMessage = "No data found";
        $webTasks = WebTasks::orderBy('id','desc')->paginate(10);
        return view('admin.webtasks.webtasks', compact('pageTitle', 'emptyMessage', 'webTasks'));
    }
    public function webTasksUploadsPost(Request $request){
        $request->validate([
            "new_task"=>"required"
        ]);
        $webTasks = new WebTasks;
        $webTasks->task_url = $request->new_task;
        $webTasks->save();
        $notify[] = ['success', 'New task added'];
        return back()->withNotify($notify);
    }
    public function userWebTaskSubmission(){
        $pageTitle = "User Web Tasks Submissions";
    	$emptyMessage = "No data found";
        $webTasks = WebTasksSubmissions::with(['user','tasks'])->orderBy('id','desc')->paginate(10);
        return view('admin.webtasks.webtasks_submissions', compact('pageTitle', 'emptyMessage', 'webTasks'));
    }
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
