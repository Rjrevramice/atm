<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gpin;
use App\Models\User;

class GeneratePinController extends Controller
{
   

    public function create()
    {
        $pageTitle = "Create Pin";
        return view('admin.generatepin.create', compact('pageTitle'));
    }

    public function index()
    {
      $pageTitle = "All Pins";
    	$emptyMessage = "No data found";
     
        $gpin  = Gpin::orderBy('id','desc')->paginate(20);

     return view('admin.generatepin.index', compact('pageTitle', 'emptyMessage','gpin'));
    }
 
  public function store(Request $request)
    {
        
         $request->validate([
          'value' => 'required', 
       ]);
         $gpin = new Gpin();

    	 $gpin->value = $request->value;
    	 $gpin->amount = $request->amount;
     
        $gpin->status = $request->status ? 0 : 1;

    	$gpin->save();

      return redirect()->route('admin.generatepin.index')
        ->with('success','Pin has been created successfully.');
    }

    public function getPin(Request $request) {    
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        echo json_encode($this->generate_string($permitted_chars, 9));
    }


    public function generate_string($input, $strength = 16) {
        $input_length = strlen($input);
        $random_string = '';
        for($i = 0; $i < $strength; $i++) {
            $random_character = $input[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }
    
        return $random_string;
    }
 
  public function remove(Request $request)
    {
//echo 1; exit;
    	 $request->validate(['id' => 'required']);
         $gpin = Gpin::findOrFail($request->id);
         $gpin->delete();
    	return redirect()->route('admin.generatepin.index')
                 ->with('success','Pin deleted successfully');
    }

}
