<?php

namespace App\Http\Controllers;

use App\Lib\GoogleAuthenticator;
use App\Models\AdminNotification;
use App\Models\Commissions;
use App\Models\GeneralSetting;
use App\Models\PlanSubscription;
use App\Models\Transaction;
use App\Models\Cart;
use App\Models\User;
use App\Models\WithdrawMethod;
use App\Models\Withdrawal;
use App\Models\Help;
use App\Models\WebTasks;
use App\Models\WebTasksSubmissions;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function __construct()
    {
        $this->activeTemplate = activeTemplate();
    }
    
    public function home()
    {
        // referrer tree 
        $jorg = new KodeInfo\JOrgChart();
        $tree = $jorg->getChart(Auth::user()->id);
        // referrer tree   
        $user = Auth::user();
        $pageTitle = 'Dashboard';
        $emptyMessage = "No data found";
       
        $deposit = auth()->user()->deposits()->sum('amount');
        $transactions = auth()->user()->transactions()->orderBy('id','desc')->limit(8)->get();
        $order = PlanSubscription::where('user_id', $user->id)->sum('amount');
        $commission = Commissions::where('user_id', $user->id)->sum('amount');
        $withdraw = Withdrawal::where('user_id', $user->id)->where('status', '!=', 0)->sum('amount');
        $transaction = auth()->user()->transactions()->count();
        $helps = Help::where('user_id',auth()->id())->get();
        return view($this->activeTemplate . 'user.dashboard', compact('helps','pageTitle', 'emptyMessage', 'deposit', 'transactions', 'order', 'commission', 'withdraw', 'transaction','tree'));
    }

    public function cart()
    {
    $pageTitle = "Cart Page";
    $user = Auth::user();
    return view($this->activeTemplate. 'user.cart', compact('pageTitle','user'));
    }

    public function profile()
    {
        $pageTitle = "Profile Setting";
        $user = Auth::user();
        return view($this->activeTemplate. 'user.profile_setting', compact('pageTitle','user'));
    }

    public function submitProfile(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string|max:50',
            // 'lastname' => 'required|string|max:50',
            'address' => 'sometimes|required|max:80',
            'state' => 'sometimes|required|max:80',
            'zip' => 'sometimes|required|max:40',
            'city' => 'sometimes|required|max:50',
            // 'acc_name' => 'sometimes|required|max:50',
            // 'acc_no' => 'sometimes|required|max:50',
            // 'br_name' => 'sometimes|required|max:50',
            // 'ifsc' => 'sometimes|required|max:50',
            'image' => ['image',new FileTypeValidate(['jpg','jpeg','png'])]
        ],[
            'firstname.required'=>'First name field is required',
            // 'lastname.required'=>'Last name field is required'
        ]);
        
        $user = Auth::user();

        $in['firstname'] = $request->firstname;
        $in['lastname'] = $request->lastname;

        $in['address'] = [
            'address' => $request->address,
            'state' => $request->state,
            'zip' => $request->zip,
            'country' => @$user->address->country,
            'city' => $request->city,
            'acc_name' => $request->acc_name,
            'acc_no' => $request->acc_no,
            'br_name' => $request->br_name,
            'ifsc' => $request->ifsc
        ];


        if ($request->hasFile('image')) {
            $img = $request->file('image');
            $imgExt = $img->getClientOriginalExtension();
            $imgName = Str::random(15).'.'.$imgExt;
            $path = "assets\images\user\profile";
            $img->move($path, $imgName);
            $in['image'] = $imgName;
        }
        $user->fill($in)->save();
        $notify[] = ['success', 'Profile updated successfully.'];
        return back()->withNotify($notify);
    }

    public function changePassword()
    {
        $pageTitle = 'Change password';
        return view($this->activeTemplate . 'user.password', compact('pageTitle'));
    }

    public function submitPassword(Request $request)
    {

        $password_validation = Password::min(6);
        $general = GeneralSetting::first();
        if ($general->secure_password) {
            $password_validation = $password_validation->mixedCase()->numbers()->symbols()->uncompromised();
        }

        $this->validate($request, [
            'current_password' => 'required',
            'password' => ['required','confirmed',$password_validation]
        ]);
        

        try {
            $user = auth()->user();
            if (Hash::check($request->current_password, $user->password)) {
                $password = Hash::make($request->password);
                $user->password = $password;
                $user->save();
                $notify[] = ['success', 'Password changes successfully.'];
                return back()->withNotify($notify);
            } else {
                $notify[] = ['error', 'The password doesn\'t match!'];
                return back()->withNotify($notify);
            }
        } catch (\PDOException $e) {
            $notify[] = ['error', $e->getMessage()];
            return back()->withNotify($notify);
        }
    }
 

    /*
     * Deposit History
     */
    public function depositHistory()
    {
        $pageTitle = 'Deposit History';
        $emptyMessage = 'No history found.';
        $logs = auth()->user()->deposits()->with(['gateway'])->orderBy('id','desc')->paginate(getPaginate());
        return view($this->activeTemplate.'user.deposit_history', compact('pageTitle', 'emptyMessage', 'logs'));
    }


    public function transactionHistory()
    {
        $pageTitle = 'Transactions History';
        $emptyMessage = 'No transaction found.';
        // $transactions = auth()->user()->transactions()->latest()->paginate(getPaginate());
        $trx = Help::where('user_id',auth()->id())->where('help_type','provide_help')->first();
        // print_r(auth()->id());die();
        return view($this->activeTemplate . 'user.transaction', compact('pageTitle', 'emptyMessage', 'trx'));
    }

    /*
     * Withdraw Operation
     */

    public function withdrawMoney()
    {
        $withdrawMethod = WithdrawMethod::where('status',1)->get();
        $pageTitle = 'Withdraw Money';
        return view($this->activeTemplate.'user.withdraw.methods', compact('pageTitle','withdrawMethod'));
    }

    public function withdrawStore(Request $request)
    {
        $this->validate($request, [
            'method_code' => 'required',
            'amount' => 'required|numeric'
        ]);
        $method = WithdrawMethod::where('id', $request->method_code)->where('status', 1)->firstOrFail();
        $user = auth()->user();
        if ($request->amount < $method->min_limit) {
            $notify[] = ['error', 'Your requested amount is smaller than minimum amount.'];
            return back()->withNotify($notify);
        }
        if ($request->amount > $method->max_limit) {
            $notify[] = ['error', 'Your requested amount is larger than maximum amount.'];
            return back()->withNotify($notify);
        }

        if ($request->amount > $user->balance) {
            $notify[] = ['error', 'You do not have sufficient balance for withdraw.'];
            return back()->withNotify($notify);
        }


        $charge = $method->fixed_charge + ($request->amount * $method->percent_charge / 100);
        $afterCharge = $request->amount - $charge;
        $finalAmount = $afterCharge * $method->rate;

        $withdraw = new Withdrawal();
        $withdraw->method_id = $method->id; // wallet method ID
        $withdraw->user_id = $user->id;
        $withdraw->amount = $request->amount;
        $withdraw->currency = $method->currency;
        $withdraw->rate = $method->rate;
        $withdraw->charge = $charge;
        $withdraw->final_amount = $finalAmount;
        $withdraw->after_charge = $afterCharge;
        $withdraw->trx = getTrx();
        $withdraw->save();
        session()->put('wtrx', $withdraw->trx);
        return redirect()->route('user.withdraw.preview');
    }

    public function withdrawPreview()
    {
        $withdraw = Withdrawal::with('method','user')->where('trx', session()->get('wtrx'))->where('status', 0)->orderBy('id','desc')->firstOrFail();
        $pageTitle = 'Withdraw Preview';
        return view($this->activeTemplate . 'user.withdraw.preview', compact('pageTitle','withdraw'));
    }


    public function withdrawSubmit(Request $request)
    {
        $general = GeneralSetting::first();
        $withdraw = Withdrawal::with('method','user')->where('trx', session()->get('wtrx'))->where('status', 0)->orderBy('id','desc')->firstOrFail();

        $rules = [];
        $inputField = [];
        if ($withdraw->method->user_data != null) {
            foreach ($withdraw->method->user_data as $key => $cus) {
                $rules[$key] = [$cus->validation];
                if ($cus->type == 'file') {
                    array_push($rules[$key], 'image');
                    array_push($rules[$key], new FileTypeValidate(['jpg','jpeg','png']));
                    array_push($rules[$key], 'max:2048');
                }
                if ($cus->type == 'text') {
                    array_push($rules[$key], 'max:191');
                }
                if ($cus->type == 'textarea') {
                    array_push($rules[$key], 'max:300');
                }
                $inputField[] = $key;
            }
        }

        $this->validate($request, $rules);
        
        $user = auth()->user();
        if ($user->ts) {
            $response = verifyG2fa($user,$request->authenticator_code);
            if (!$response) {
                $notify[] = ['error', 'Wrong verification code'];
                return back()->withNotify($notify);
            }   
        }


        if ($withdraw->amount > $user->balance) {
            $notify[] = ['error', 'Your request amount is larger then your current balance.'];
            return back()->withNotify($notify);
        }

        $directory = date("Y")."/".date("m")."/".date("d");
        $path = imagePath()['verify']['withdraw']['path'].'/'.$directory;
        $collection = collect($request);
        $reqField = [];
        if ($withdraw->method->user_data != null) {
            foreach ($collection as $k => $v) {
                foreach ($withdraw->method->user_data as $inKey => $inVal) {
                    if ($k != $inKey) {
                        continue;
                    } else {
                        if ($inVal->type == 'file') {
                            if ($request->hasFile($inKey)) {
                                try {
                                    $reqField[$inKey] = [
                                        'field_name' => $directory.'/'.uploadImage($request[$inKey], $path),
                                        'type' => $inVal->type,
                                    ];
                                } catch (\Exception $exp) {
                                    $notify[] = ['error', 'Could not upload your ' . $request[$inKey]];
                                    return back()->withNotify($notify)->withInput();
                                }
                            }
                        } else {
                            $reqField[$inKey] = $v;
                            $reqField[$inKey] = [
                                'field_name' => $v,
                                'type' => $inVal->type,
                            ];
                        }
                    }
                }
            }
            $withdraw['withdraw_information'] = $reqField;
        } else {
            $withdraw['withdraw_information'] = null;
        }


        $withdraw->status = 2;
        $withdraw->save();
        $user->balance  -=  $withdraw->amount;
        $user->save();



        $transaction = new Transaction();
        $transaction->user_id = $withdraw->user_id;
        $transaction->amount = $withdraw->amount;
        $transaction->post_balance = $user->balance;
        $transaction->charge = $withdraw->charge;
        $transaction->trx_type = '-';
        $transaction->details = showAmount($withdraw->final_amount) . ' ' . $withdraw->currency . ' Withdraw Via ' . $withdraw->method->name;
        $transaction->trx =  $withdraw->trx;
        $transaction->save();

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = $user->id;
        $adminNotification->title = 'New withdraw request from '.$user->username;
        $adminNotification->click_url = urlPath('admin.withdraw.details',$withdraw->id);
        $adminNotification->save();

        notify($user, 'WITHDRAW_REQUEST', [
            'method_name' => $withdraw->method->name,
            'method_currency' => $withdraw->currency,
            'method_amount' => showAmount($withdraw->final_amount),
            'amount' => showAmount($withdraw->amount),
            'charge' => showAmount($withdraw->charge),
            'currency' => $general->cur_text,
            'rate' => showAmount($withdraw->rate),
            'trx' => $withdraw->trx,
            'post_balance' => showAmount($user->balance),
            'delay' => $withdraw->method->delay
        ]);

        $notify[] = ['success', 'Withdraw request sent successfully'];
        return redirect()->route('user.withdraw.history')->withNotify($notify);
    }

    public function withdrawLog()
    {
        $pageTitle = "Withdraw Log";
        $withdraws = Withdrawal::where('user_id', Auth::id())->where('status', '!=', 0)->with('method')->orderBy('id','desc')->paginate(getPaginate());
        $data['emptyMessage'] = "No Data Found!";
        return view($this->activeTemplate.'user.withdraw.log', compact('pageTitle','withdraws'));
    }

    public function show2faForm()
    {
        $general = GeneralSetting::first();
        $ga = new GoogleAuthenticator();
        $user = auth()->user();
        $secret = $ga->createSecret();
        $qrCodeUrl = $ga->getQRCodeGoogleUrl($user->username . '@' . $general->sitename, $secret);
        $pageTitle = 'Two Factor';
        return view($this->activeTemplate.'user.twofactor', compact('pageTitle', 'secret', 'qrCodeUrl'));
    }

    public function create2fa(Request $request)
    {
        $user = auth()->user();
        $this->validate($request, [
            'key' => 'required',
            'code' => 'required',
        ]);
        $response = verifyG2fa($user,$request->code,$request->key);
        if ($response) {
            $user->tsc = $request->key;
            $user->ts = 1;
            $user->save();
            $userAgent = getIpInfo();
            $osBrowser = osBrowser();
            notify($user, '2FA_ENABLE', [
                'operating_system' => @$osBrowser['os_platform'],
                'browser' => @$osBrowser['browser'],
                'ip' => @$userAgent['ip'],
                'time' => @$userAgent['time']
            ]);
            $notify[] = ['success', 'Google authenticator enabled successfully'];
            return back()->withNotify($notify);
        } else {
            $notify[] = ['error', 'Wrong verification code'];
            return back()->withNotify($notify);
        }
    }

    public function disable2fa(Request $request)
    {
        $this->validate($request, [
            'code' => 'required',
        ]);
        $user = auth()->user();
        $response = verifyG2fa($user,$request->code);
        if ($response) {
            $user->tsc = null;
            $user->ts = 0;
            $user->save();
            $userAgent = getIpInfo();
            $osBrowser = osBrowser();
            notify($user, '2FA_DISABLE', [
                'operating_system' => @$osBrowser['os_platform'],
                'browser' => @$osBrowser['browser'],
                'ip' => @$userAgent['ip'],
                'time' => @$userAgent['time']
            ]);
            $notify[] = ['success', 'Two factor authenticator disable successfully'];
        } else {
            $notify[] = ['error', 'Wrong verification code'];
        }
        return back()->withNotify($notify);
    }

    public function balanceTransfer()
    {
        $general= GeneralSetting::first();
        if($general->balance_transfer != 1)
        {
            $notify[] = ['warning', "Balance transfer doesn't available this time"];
            return redirect()->route('user.home')->withNotify($notify);
        }
        $pageTitle = "Balance Transfer";
        return view($this->activeTemplate.'user.balance_transfer', compact('pageTitle'));
    }


     public function balanceTransferUser(Request $request)
    {
        $general= GeneralSetting::first();
        if($general->balance_transfer != 1)
        {
            $notify[] = ['warning', "Balance transfer doesn't available this time"];
            return redirect()->route('home')->withNotify($notify);;
        }
        $this->validate($request, [
            'amount' => 'required|numeric|gt:0',
            'username' => 'required'
        ]);
        $user = Auth::user();
        $toUser = User::where('status', 1)->where('username', $request->username)->first();
        if(!$toUser){
            $notify[] = ['error', 'Receiver not found'];
            return back()->withNotify($notify);
        }
        if($user->id == $toUser->id)
        {
            $notify[] = ['error', "You can not transfer balance to self account."];
            return back()->withNotify($notify);
        }
        $charge = (($request->amount / 100) * $general->balance_transfer_percent_charge) + $general->balance_transfer_fixed_charge;
        $total = $request->amount + $charge;

        if($total > $user->balance){
            $notify[] = ['error', 'Your account balance '.getAmount($user->balance) . ' ' . $general->cur_text .' not enough for balance transfer'];
            return back()->withNotify($notify);
        }
        $user->balance -=  $total;
        $user->save();

        $transaction = new Transaction();
        $transaction->user_id = $user->id;
        $transaction->amount = $total;
        $transaction->post_balance = $user->balance;
        $transaction->charge = $charge;
        $transaction->trx_type = '-';
        $transaction->details = 'Balance Transfered To ' . $toUser->username;
        $transaction->trx = getTrx();
        $transaction->save();

        notify($user, 'BAL_TRANSFER_SENDER', [
            'trx' => $transaction->trx,
            'amount' => getAmount($request->amount),
            'charge' => getAmount($charge),
            'afterCharge' => getAmount($total),
            'currency' => $general->cur_text,
            'post_balance' => getAmount($user->balance),
        ]);

        $toUser->balance += $request->amount;
        $toUser->save();

        $tranUser = new Transaction();
        $tranUser->user_id = $toUser->id;
        $tranUser->amount = $request->amount;
        $tranUser->post_balance = $toUser->balance;
        $tranUser->trx_type = '+';
        $tranUser->details = 'Balance Transfered From ' . $user->username;
        $tranUser->trx = $transaction->trx;
        $tranUser->save();

        notify($toUser, 'BAL_TRANSFER_RECEVER', [
            'trx' => $tranUser->trx,
            'amount' => getAmount($tranUser->amount),
            'currency' => $general->cur_text,
            'post_balance' => getAmount($toUser->balance),
        ]);

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = $user->id;
        $adminNotification->title = 'Balance Transfered To ' . $toUser->username;
        $adminNotification->click_url = urlPath('admin.report.transaction');
        $adminNotification->save();

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = $user->id;
        $adminNotification->title = 'Balance Transfered From ' . $user->username;
        $adminNotification->click_url = urlPath('admin.report.transaction');
        $adminNotification->save();
        
        $notify[] = ['success', 'Balance has been transfer'];
        return back()->withNotify($notify);
    }


    public function referrallog()
    {
        $user = Auth::user();
        $pageTitle = 'My Referred Users';
        $emptyMessage = 'No data found';
        $referrals = User::where('ref_by', $user->id)->latest()->paginate(getPaginate());
        $order = PlanSubscription::where('user_id', $user->id)->first();
        return view($this->activeTemplate . 'user.referral', compact('pageTitle', 'emptyMessage', 'referrals', 'order'));
    }


    public function referralCommission()
    {
        $user = Auth::user();
        $pageTitle = "My Referral Commissions";
        $emptyMessage = "No data found";
        $commissions = Commissions::where('user_id', $user->id)->where('mark', 1)->with('fromUser')->orderBy('id', 'desc')->paginate(getPaginate());
        return view($this->activeTemplate . 'user.commission', compact('pageTitle', 'emptyMessage', 'commissions'));
    }


    public function levelCommission()
    {
        $user = Auth::user();
        $pageTitle = "My Level Commissions";
        $emptyMessage = "No data found";
        $commissions = Commissions::where('user_id', $user->id)->where('mark', 2)->with('fromUser')->orderBy('id', 'desc')->paginate(getPaginate());
        return view($this->activeTemplate . 'user.commission', compact('pageTitle', 'emptyMessage', 'commissions'));
    }


     public function userLevelReferral(Request $request)
    {
        $levelId = $request->level;
        $pageTitle = "My Level ". $levelId . " Referred User";
        $emptyMessage =  "No data found";
        $user = Auth::user();
        $order = PlanSubscription::where('user_id', $user->id)->first();
        $general = GeneralSetting::first();
        
        if($levelId > $general->matrix_height)
        {
            $notify[] = ['error', 'No Level Found.'];
            return back()->withNotify($notify);
        }
        $myReferral = $this->showBelow($user->id);
        $nextArray = $myReferral;
        for($i=1; $i<$levelId; $i++)
        {
            $nextArray = array();
            foreach($myReferral as $underRefer)
            {
                $newdata = $this->showBelow($underRefer);
                $nextArray = array_merge($nextArray, $newdata);
            }
            $myReferral = $nextArray;
        }
        return view($this->activeTemplate . 'user.referral_level', compact('pageTitle', 'emptyMessage', 'nextArray', 'levelId', 'order'));
    }


    private function showBelow($id)
    {
        $newArray = array();
        $underReferral = User::where('position_id', $id)->get();
        foreach($underReferral as $value)
        {
            array_push($newArray, $value->id);
        }
        return $newArray;
    }
    public function provide_help(Request $request){
        if(empty(auth()->user()->acc_holder_number)){
            $notify[] = ['error', 'Please fill your bank account details in account section'];
            return back()->withNotify($notify);
        }
        date_default_timezone_set("Asia/Kolkata");
        $currentTimestamp = time();
        $currentTime = date('H:i:s', $currentTimestamp);

        $this->validate($request, [
            'currency' => 'required',
            'amount' => 'required|numeric',
            'return_percentage' => 'required'
        ]);
        $help = new Help;
        $help->currency = $request->currency;
        $help->amount = $request->amount;
        $help->return_percentage = $request->return_percentage;
        $help->help_type = "provide_help";
        $help->current_token = "PROVIDE-".rand(1000000,9999999).auth()->id();
        $help->user_id = auth()->id();
        $help->time = $currentTime;
        $help->save();
        $notify[] = ['success', 'Your Provide Help Ticket is Raised'];
        return back()->withNotify($notify);
    }
    public function account_details(Request $request){
        $pageTitle = "Account Details";
        $user = Auth::user();
        return view($this->activeTemplate. 'user.twofactor', compact('pageTitle','user'));
        
    }
    public function account_save(Request $request){
        $user =  User::where('id',auth()->id())->first();
        $user->acc_holder_name = $request->acc_name;
        $user->acc_holder_number = $request->acc_no;
        $user->br_name = $request->br_name;
        $user->ifsc = $request->ifsc;
        $user->upi_id = $request->upi_id;
        $user->save();
        $notify[] = ['success', 'Account details saved successfully'];
        return back()->withNotify($notify);
    }
    public function save_get_help(Request $request){
        $this->validate($request, [
            'currency' => 'required',
            'amount' => 'required|numeric',
        ]);
        $help = new Help;
        $help->currency = $request->currency;
        $help->amount = $request->amount;
        $help->user_id = auth()->id();
        $help->current_token = "GET-".rand(1000000,9999999).auth()->id();
        $help->help_type = "get_help";
        $help->time = time();
        $help->save();
        $notify[] = ['success', 'Your Get Help Ticket is Raised'];
        return back()->withNotify($notify);
    }
    public function growth_balance($grow){
        $pageTitle = "Growth Balance";
        $user = Auth::user();
        $growth = Help::where('help_type','provide_help')->get();
        $emptyMessage = "Not Found";
        return view($this->activeTemplate. 'user.growth_balance', compact('pageTitle','user','growth','emptyMessage'));
    }
    public function saveProof($saveProof,Request $request){
       $help = Help::where('id',$request->help_id)->first();
       if($image = $request->file('image')){
            $imageName = Str::random(15).'.'.$image->getClientOriginalExtension();
            $path = public_path('/');
            $image->move($path, $imageName);
            $help->proof = $imageName;
            $help->save();
            $imageFullPath = url('/core/public').'/'.$imageName;
            return response()->json([
                'status'=>200,
                'message'=>'Successfully added',
                'data'=>$imageFullPath
            ]);
       }
    }
    public function webTasks($tasks){
        $pageTitle = "Web Tasks";
        $taskLinks = WebTasks::latest()->first();
        // print_r($taskLinks);die();
        $emptyMessage = "No Web Tasks Found";
        return view($this->activeTemplate. 'user.webtasks', compact('pageTitle','taskLinks','emptyMessage'));
    }
    public function submitWebTasks($tasks ,Request $request){
        $webTasksSubmissions = new WebTasksSubmissions;
        $webTasksSubmissions->user_id = auth()->id();
        $webTasksSubmissions->task_id = $request->task_id;
        $webTasksSubmissions->submitted_url = $request->submit_url;
        $webTasksSubmissions->save();
        $notify[] = ['success', 'Your submission added successfully'];
        return back()->withNotify($notify);
    }
    public function cancel_help(Request $request){
        if($request->query('id')){
            Help::where('id',$request->query('id'))->delete();
            return true;
        }else{
            return false;
        }
       
    }
}
