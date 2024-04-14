<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Frontend;
use App\Models\GeneralSetting;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Image;

class GeneralSettingController extends Controller
{
    public function index()
    {
        $general = GeneralSetting::first();
        $pageTitle = 'General Setting';
        $timezones = json_decode(file_get_contents(resource_path('views/admin/partials/timezone.json')));
        return view('admin.setting.general_setting', compact('pageTitle', 'general','timezones'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'base_color' => 'nullable', 'regex:/^[a-f0-9]{6}$/i',
            'secondary_color' => 'nullable', 'regex:/^[a-f0-9]{6}$/i',
            'timezone' => 'required',
        ]);

        $general = GeneralSetting::first();
        $general->ev = $request->ev ? 1 : 0;
        $general->en = $request->en ? 1 : 0;
        $general->sv = $request->sv ? 1 : 0;
        $general->sn = $request->sn ? 1 : 0;
        $general->force_ssl = $request->force_ssl ? 1 : 0;
        $general->secure_password = $request->secure_password ? 1 : 0;
        $general->registration = $request->registration ? 1 : 0;
        $general->agree = $request->agree ? 1 : 0;
        $general->balance_transfer = $request->balance_transfer ? 1 : 0;
        $general->epin_status = $request->epin_status ? 1 : 0;
        $general->sitename = $request->sitename;
        $general->cur_text = $request->cur_text;
        $general->cur_sym = $request->cur_sym;
        $general->base_color = $request->base_color;
        $general->secondary_color = $request->secondary_color;
        $general->balance_transfer_fixed_charge = $request->balance_transfer_fixed_charge;
        $general->balance_transfer_percent_charge = $request->balance_transfer_percent_charge;
        $general->epin_charge = $request->epin_charge;
        $general->save();

        $timezoneFile = config_path('timezone.php');
        $content = '<?php $timezone = '.$request->timezone.' ?>';
        file_put_contents($timezoneFile, $content);
        $notify[] = ['success', 'General setting has been updated.'];
        return back()->withNotify($notify);
    }


    public function logoIcon()
    {
        $pageTitle = 'Logo & Favicon';
        return view('admin.setting.logo_icon', compact('pageTitle'));
    }

    public function logoIconUpdate(Request $request) 
    {
        $request->validate([
            'logo' => ['image',new FileTypeValidate(['jpg','jpeg','png'])],
            'favicon' => ['image',new FileTypeValidate(['png'])],
        ]);
        if ($request->hasFile('logo')) {
            try {
                // $path = imagePath()['logoIcon']['path'];
                $image = $request->file('logo');
                $imgName = Str::random(15).'.'.$image->getClientOriginalExtension();
                $path = public_path('/logoIcon');
                $image->move($path,$imgName);
                $encode = [ "image"=>$imgName];
                DB::table('frontends')->updateOrInsert([
                    "data_keys"=>"logo",
                ],["data_values"=>json_encode($encode)]);
                // if (!file_exists($path)) {
                //     mkdir($path, 0755, true);
                // }
                // Image::make($request->logo)->save($path . '/logo.png');
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Logo could not be uploaded.'];
                return back()->withNotify($notify);
            }
        }

        if ($request->hasFile('favicon')) {
            try {
                $image = $request->file('favicon');
                $imgName = Str::random(15).'.'.$image->getClientOriginalExtension();
                $path = public_path('/logoIcon');
                $image->move($path,$imgName);
                $encode = ["image"=>$imgName];
                DB::table('frontends')->updateOrInsert([
                    "data_keys"=>"favicon",
                ],["data_values"=>json_encode($encode)]);
                // $path = imagePath()['logoIcon']['path'];
                // if (!file_exists($path)) {
                //     mkdir($path, 0755, true);
                // }
                // $size = explode('x', imagePath()['favicon']['size']);
                // Image::make($request->favicon)->resize($size[0], $size[1])->save($path . '/favicon.png');
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Favicon could not be uploaded.'];
                return back()->withNotify($notify);
            }
        }
        $notify[] = ['success', 'Logo & favicon has been updated.'];
        return back()->withNotify($notify);
    }

    public function customCss(){
        $pageTitle = 'Custom CSS';
        $file = activeTemplate(true).'css/custom.css';
        $file_content = @file_get_contents($file);
        return view('admin.setting.custom_css',compact('pageTitle','file_content'));
    }


    public function customCssSubmit(Request $request){
        $file = activeTemplate(true).'css/custom.css';
        if (!file_exists($file)) {
            fopen($file, "w");
        }
        file_put_contents($file,$request->css);
        $notify[] = ['success','CSS updated successfully'];
        return back()->withNotify($notify);
    }

    public function optimize(){
        Artisan::call('optimize:clear');
        $notify[] = ['success','Cache cleared successfully'];
        return back()->withNotify($notify);
    }


    public function cookie(){
        $pageTitle = 'GDPR Cookie';
        $cookie = Frontend::where('data_keys','cookie.data')->firstOrFail();
        return view('admin.setting.cookie',compact('pageTitle','cookie'));
    }

    public function cookieSubmit(Request $request){
        $request->validate([
            'link'=>'required',
            'description'=>'required',
        ]);
        $cookie = Frontend::where('data_keys','cookie.data')->firstOrFail();
        $cookie->data_values = [
            'link' => $request->link,
            'description' => $request->description,
            'status' => $request->status ? 1 : 0,
        ];
        $cookie->save();
        $notify[] = ['success','Cookie policy updated successfully'];
        return back()->withNotify($notify);
    }
}
