<?php

namespace App\Http\Controllers;
use App\Models\AdminNotification;
use App\Models\Frontend;
use App\Models\Language;
use App\Models\Page;
use App\Models\Category;
use App\Models\Product;
use App\Models\Subscriber;
use App\Models\SupportAttachment;
use App\Models\SupportMessage;
use App\Models\SupportTicket;
use Carbon\Carbon;
use Validator;
use Illuminate\Http\Request;


class SiteController extends Controller
{
    public function __construct(){
        $this->activeTemplate = activeTemplate();
    }

    public function index(){ 
        $count = Page::where('tempname',$this->activeTemplate)->where('slug','home')->count();
        if($count == 0){
            $page = new Page();
            $page->tempname = $this->activeTemplate;
            $page->name = 'HOME';
            $page->slug = 'home';
            $page->save();
        }

         $reference = @$_GET['reference'];
        if ($reference) {
            session()->put('reference', $reference);
        }
         $category =  Category::limit(2)->get();
         $products = Product::where('status',1)->limit(8)->get();
        $pageTitle = 'Home';
        $sections = Page::where('tempname',$this->activeTemplate)->where('slug','home')->first();

        return view($this->activeTemplate . 'home', compact('pageTitle','sections','category','products'));
  }

    public function pages($slug)
    {
        $page = Page::where('tempname',$this->activeTemplate)->where('slug',$slug)->firstOrFail();
        $pageTitle = $page->name;
        $sections = $page->secs;
        return view($this->activeTemplate . 'pages', compact('pageTitle','sections'));
    }

     public function contact()
        {
        $pageTitle = "Contact Us";
        return view($this->activeTemplate . 'contact',compact('pageTitle'));
         }


    public function contactSubmit(Request $request)
    {

        $attachments = $request->file('attachments');
        $allowedExts = array('jpg', 'png', 'jpeg', 'pdf');

        $this->validate($request, [
            'name' => 'required|max:191',
            'email' => 'required|max:191',
            'subject' => 'required|max:100',
            'message' => 'required',
        ]);


        $random = getNumber();

        $ticket = new SupportTicket();
        $ticket->user_id = auth()->id() ?? 0;
        $ticket->name = $request->name;
        $ticket->email = $request->email;
        $ticket->priority = 2;


        $ticket->ticket = $random;
        $ticket->subject = $request->subject;
        $ticket->last_reply = Carbon::now();
        $ticket->status = 0;
        $ticket->save();

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = auth()->user() ? auth()->user()->id : 0;
        $adminNotification->title = 'A new support ticket has opened ';
        $adminNotification->click_url = urlPath('admin.ticket.view',$ticket->id);
        $adminNotification->save();

        $message = new SupportMessage();
        $message->supportticket_id = $ticket->id;
        $message->message = $request->message;
        $message->save();
        
        $notify[] = ['success', 'ticket created successfully!'];

        return redirect()->route('ticket.view', [$ticket->ticket])->withNotify($notify);
    }

    public function changeLanguage($lang = null)
    {
        $language = Language::where('code', $lang)->first();
        if (!$language) $lang = 'en';
        session()->put('lang', $lang);
        return redirect()->back();
    }

    public function blog()
    {
        $pageTitle = "Blog";
        $blogs = Frontend::where('data_keys','blog.element')->latest()->paginate(getPaginate());
        return view($this->activeTemplate . 'blog',compact('pageTitle', 'blogs'));
    }

    public function blogDetails($id,$slug){
        $recentBlogs = Frontend::where('data_keys','blog.element')->latest()->limit(6)->get();
        $blog = Frontend::where('id',$id)->where('data_keys','blog.element')->firstOrFail();
        $pageTitle = $blog->data_values->title;
        return view($this->activeTemplate.'blog_details',compact('blog','pageTitle', 'recentBlogs'));
    }


    public function cookieAccept(){
        session()->put('cookie_accepted',true);
        $notify[] = ['success','Cookie accepted successfully'];
        return back()->withNotify($notify);
    }

    public function placeholderImage($size = null){
        $imgWidth = explode('x',$size)[0];
        $imgHeight = explode('x',$size)[1];
        $text = $imgWidth . '×' . $imgHeight;
        $fontFile = realpath('assets/font') . DIRECTORY_SEPARATOR . 'RobotoMono-Regular.ttf';
        $fontSize = round(($imgWidth - 50) / 8);
        if ($fontSize <= 9) {
            $fontSize = 9;
        }
        if($imgHeight < 100 && $fontSize > 30){
            $fontSize = 30;
        }
        $image     = imagecreatetruecolor($imgWidth, $imgHeight);
        $colorFill = imagecolorallocate($image, 100, 100, 100);
        $bgFill    = imagecolorallocate($image, 175, 175, 175);
        imagefill($image, 0, 0, $bgFill);
        $textBox = imagettfbbox($fontSize, 0, $fontFile, $text);
        $textWidth  = abs($textBox[4] - $textBox[0]);
        $textHeight = abs($textBox[5] - $textBox[1]);
        $textX      = ($imgWidth - $textWidth) / 2;
        $textY      = ($imgHeight + $textHeight) / 2;
        header('Content-Type: image/jpeg');
        imagettftext($image, $fontSize, 0, $textX, $textY, $colorFill, $fontFile, $text);
        imagejpeg($image);
        imagedestroy($image);
    }

    public function subscribe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);
        if($validator->fails()) {
            return response()->json($validator->errors());
        }
        $if_exist = Subscriber::where('email', $request->email)->first();
        if (!$if_exist) {
            Subscriber::create([
                'email' => $request->email
            ]);
            return response()->json(['success' => 'Subscribed Successfully']);
        }else {
            return response()->json(['error' => 'Already Subscribed']);
        }
    }

    public function footerMenu($slug, $id)
    {
        $data = Frontend::where('id', $id)->where('data_keys', 'policy_pages.element')->firstOrFail();
        $pageTitle =  $data->data_values->menu;
        return view($this->activeTemplate . 'menu', compact('data', 'pageTitle'));
    }

    public function idealogy($idea){
        $pageTitle = "Idealogy";
        return view('templates.basic.idealogy',compact('pageTitle'));
    }
    public function plan_detail($detail){
        $pageTitle = "Plan Detail";
        return view('templates.basic.plan_detail',compact('pageTitle'));
    }

}
