<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use App\Models\GeneralSetting;
use App\Models\User;
use App\Models\Plan;
use App\Models\ReturnPayment;
use App\Models\UserLogin;
use App\Models\Gpin;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use App\Models\PlanSubscription;
use DateTime;

use App\Models\Commissions;
use App\Models\Transaction;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        $this->middleware('regStatus')->except('registrationNotAllowed');

        $this->activeTemplate = activeTemplate();
    }

    public function showRegistrationForm()
    {
        $pageTitle = "Sign Up";
        $info = json_decode(json_encode(getIpInfo()), true);
        if(isset($info['code'])){
            $mobile_code = @implode(',', $info['code']);
        }else{
            $mobile_code = "";
        }
        
        $countries = json_decode(file_get_contents(resource_path('views/partials/country.json')));
        return view($this->activeTemplate . 'user.auth.register', compact('pageTitle','mobile_code','countries'));
    }


    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $general = GeneralSetting::first();
        $password_validation = Password::min(6);
        if ($general->secure_password) {
            $password_validation = $password_validation->mixedCase()->numbers()->symbols()->uncompromised();
        }
        $agree = 'nullable';
        if ($general->agree) {
            $agree = 'required';
        }
        $countryData = (array)json_decode(file_get_contents(resource_path('views/partials/country.json')));
        $countryCodes = implode(',', array_keys($countryData));
        $mobileCodes = implode(',',array_column($countryData, 'dial_code'));
        $countries = implode(',',array_column($countryData, 'country'));
        $validate = Validator::make($data, [
            'firstname' => 'sometimes|required|string|max:50',
            'referBy' => 'required|max:80',
            // 'lastname' => 'sometimes|required|string|max:50',
            'email' => 'required|string|email|max:90',
            'mobile' => 'required|string|max:50',
            // 'pin' => 'required|max:50',
            'password' => ['required','confirmed',$password_validation],
            // 'username' => 'required|alpha_num|unique:users',
            // 'captcha' => 'sometimes|required',
            // 'mobile_code' => 'required|in:'.$mobileCodes,
            // 'country_code' => 'required|in:'.$countryCodes,
            'country' => 'required|in:'.$countries,
            'agree' => $agree
        ]);
        return $validate;
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        /*
        $exist = User::where('mobile',$request->mobile_code.$request->mobile)->first();
        if ($exist) {
            $notify[] = ['error', 'The mobile number already exists'];
            return back()->withNotify($notify)->withInput();
        }
        */
    
        // $referUser = User::where('username', $request->referBy)->first();
     
        // if(!$referUser){
        //     $notify[] = ['error', "Invalid Member Id"];
        //     return back()->withNotify($notify)->withInput();
        // }

        // if (isset($request->captcha)) {
        //     if (!captchaVerify($request->captcha, $request->captcha_secret)) {
        //         $notify[] = ['error', "Invalid captcha"];
        //         return back()->withNotify($notify)->withInput();
        //     }
        // }

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }


    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        $general = GeneralSetting::first();

        $referBy = $data['referBy'];
        if ($referBy) {
            $referUser = User::where('my_refer_code', $referBy)->first();
        } else {
            $referUser = null;
        }
      
        //User Create
        //get Plan amunt from default
        
        // $planAmount = Gpin::where('value',$data['pin'])->select('amount')->first();
        // $planAmount = Plan::where('id',1)->select('price')->first();
        $generateUserName  = "ATM".rand(1000,9999);
        $user = new User();
        $user->firstname = isset($data['firstname']) ? $data['firstname'] : null;
        $user->lastname = isset($data['lastname']) ? $data['lastname'] : null;
        $user->email = strtolower(trim($data['email']));
        $user->password = Hash::make($data['password']);
        // $user->username = trim($data['username']);
        $user->username = $generateUserName;
        $user->ref_by = $referUser ? $referUser->id : 0;
        
        $user->country_code = $data['country_code'];
        $user->balance = 0;
        
        
        $user->mobile = $data['mobile_code'].$data['mobile'];
        $user->pin = isset($data['pin']) ? $data['pin'] : null;
     
        

        $user->address = [
            'address' => '',
            'state' => '',
            'zip' => '',
            'country' => isset($data['country']) ? $data['country'] : null,
            'city' => '',
            'acc_name' => '',
            'acc_no' => '',
            'br_name' => '',
            'ifsc' => ''
        ];
        $user->status = 1;
        $user->ev = $general->ev ? 0 : 1;
        $user->sv = $general->sv ? 0 : 1;
        $user->ts = 0;
        $user->tv = 1;


     
       
        $user->save();
        $saveReferCode = User::where('id',$user->id)->first();
        if($saveReferCode){
            $saveReferCode->my_refer_code = "ATM".time().$user->id;
            $saveReferCode->save();
        }
        $userIpInfo = getIpInfo();
        $userBrowserInfo = osBrowser();
      
        sendEmail($user, 'REGISTER', [
            'operating_system' => @$userBrowserInfo['os_platform'],
            'browser' => @$userBrowserInfo['browser'],
            'ip' => @$userIpInfo['ip'],
            'time' => @$userIpInfo['time']
        ]);
        $email = $user->email;

        session()->put('REGISTER',$email);
        $notify[] = ['success', 'Successfully User Registered'];
       
        
        // write by kishore 
        // $gpin =  Gpin::where('value',$data['pin'])->first();
        // $gpin->status = 0;
        // $gpin->save();
        
        $adminNotification = new AdminNotification();
        $adminNotification->user_id = $user->id;
        $adminNotification->title = 'New member registered';
        $adminNotification->click_url = urlPath('admin.users.detail',$user->id);
        $adminNotification->save();
  

        //Login Log Create
        $ip = $_SERVER["REMOTE_ADDR"];
        $exist = UserLogin::where('user_ip',$ip)->first();
        $userLogin = new UserLogin();

        //Check exist or not
        if ($exist) {
            $userLogin->longitude =  $exist->longitude;
            $userLogin->latitude =  $exist->latitude;
            $userLogin->city =  $exist->city;
            $userLogin->country_code = $exist->country_code;
            $userLogin->country =  $exist->country;
        }else{
            $info = json_decode(json_encode(getIpInfo()), true);
            $userLogin->longitude =  @implode(',',$info['long']);
            $userLogin->latitude =  @implode(',',$info['lat']);
            $userLogin->city =  @implode(',',$info['city']);
            $userLogin->country_code = @implode(',',$info['code']);
            $userLogin->country =  @implode(',', $info['country']);
        }

        $userAgent = osBrowser();
        $userLogin->user_id = $user->id;
        $userLogin->user_ip =  $ip;
        
        $userLogin->browser = @$userAgent['browser'];
        $userLogin->os = @$userAgent['os_platform'];
        $userLogin->save();

        //subscription plan create and create commission
        // $this->planOrder(1, $user,$data['pin']);  
        // $this->returnPayment($user->id);

        return $user;


    }

    public function checkUser(Request $request){
        $exist['data'] = null;
        $exist['type'] = null;
        if ($request->email) {
            $exist['data'] = User::where('email',$request->email)->first();
            $exist['type'] = 'email';
        }
        if ($request->mobile) {
            $exist['data'] = User::where('mobile',$request->mobile)->first();
            $exist['type'] = 'mobile';
        }
        if ($request->username) {
            $exist['data'] = User::where('username',$request->username)->first();
            $exist['type'] = 'username';
        }
        return response($exist);
    }

    public function registered()
    {
        
        return redirect()->route('user.home');
    }

    public function validatePin(Request $request){
        $pin = $request->pin;
        //check for pin
        $check = Gpin::where('status',1)->where('value',$pin)->first();
        if($check){
            return response()->json([
                'message' => 'Pin Verified Successfully'
            ], 200);
        }else{
            return response()->json([
                'message' => 'Pin Is Invalid'
            ], 400);
        }
    }
    public function fetchUsername(Request $request){
        $username = $request->pin;
        $check = User::where('my_refer_code',$username)->first();
        if($check){
            return response()->json([
                'message' => 'Refer Code Verified Successfully',
                'data' => $check->firstname
            ], 200);
        }else{
            return response()->json([
                'message' => 'Refer Code Is Invalid',
                'data' => "Refer Code Is Invalid"
            ], 400);
        }
    }

    //return payment months
    public function returnPayment($user_id){
        $plan = Plan::where('id',1)->first();
        if($plan->month > 0 ){
            $partitionMonth = $plan->month;
        }else{
            $partitionMonth = 20;
        }
        

        for($i=1;$i<=$partitionMonth;$i++){
            
            $incrementDate = date('Y-m-d', strtotime(date("Y-m-d"). ' + '.$i.' months')); 
            $timestamp = strtotime($incrementDate);
            if(date("d", $timestamp) < 15)
            {
                $date = date("Y", $timestamp)."-".date("m", $timestamp)."-15";
            }else{
                $date1 = new DateTime($incrementDate);
                $date1->modify('last day of this month');
                $date1->format('Y-m-d');
                $date = $date1->format('Y-m-d');
            }
            
            ReturnPayment::insert([
                'user_id' => $user_id,
                'date' => $date
            ]);
        }
        
    }

    // plan subscription
    public function planOrder($planId, $user,$register_pin)
    {
        $plan = Plan::where('id',$planId)->firstOrFail();
        $planAmount = Gpin::where('value',$register_pin)->select('amount')->first();

        $user->balance -= $planAmount->amount;
        $user->save();

        $trx =  getTrx();
        $order = new PlanSubscription();
        $order->user_id = $user->id;
        $order->plan_id = $plan->id;
        $order->amount = $planAmount->amount;
        $order->order_number = $trx;
        $order->save();

        $transaction = new Transaction();
        $transaction->user_id = $user->id;
        $transaction->amount = $order->amount;
        $transaction->post_balance = $user->balance;
        $transaction->trx_type = '-';
        $transaction->details = 'Subscribe Plan '. $plan->name;
        $transaction->trx = $trx;
        $transaction->save();

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = $user->id;
        $adminNotification->title = 'Plan subscribe successful';
        $adminNotification->click_url = urlPath('admin.plan.subscribers.index');
        $adminNotification->save();

        $planOrder = PlanSubscription::where('user_id', $user->id)->first();
        if($user->ref_by != null)
        {
            if($planOrder)
            {
    		    $this->positionFixed($user->id);
    		    // $this->referralCommission($user->id, $plan->id);
            }
    	}
        if($planOrder)
        {
            $this->levelCommission($user->id, $plan->id, $planAmount->amount);
        }
        return true;
    }
    
    private function positionFixed($userId)
    {
    	$user = User::find($userId);
    	$referBy = User::find($user->ref_by);
        $checkPosition = 0;
    	if($this->checkReferUserEmpty($referBy->id) != 0){
    		$user->position_id = $referBy->id;
            $user->position =$this->checkReferUserEmpty($referBy->id);
            $user->save();
    	}
    	else{
            for($level=1; $level <100; $level++){
                $myReferralUser = $this->showPosition($referBy->id);
                $nextReferral = $myReferralUser;
                for($i=1; $i<$level; $i++)
                {
                    $nextReferral = array();
                    foreach($myReferralUser as $dataReferral){
                        $n=$this->showPosition($dataReferral);
                        $nextReferral = array_merge($nextReferral, $n);
                    }
                    $myReferralUser = $nextReferral;
                }
                foreach($nextReferral as $valueNextReferral){
                    if($this->checkReferUserEmpty($valueNextReferral) != 0){
                        $user->position_id = $valueNextReferral;
                        $user->position = $this->checkReferUserEmpty($valueNextReferral);
                        $user->save();
                        $checkPosition =1;
                    }
                    if($checkPosition == 1){
                        break;
                    }
                }
                if($checkPosition == 1){
                    break;
                }
            }
    	}
    }

    private function checkReferUserEmpty($referByID)
    {
    	$count = User::where('position_id',$referByID)->count();
        if($count < $this->general()->matrix_width){
            return $count+1;
        }else{
            return 0;
        }
    }

    private function showPosition($referByID)
    {
        $newArray = array();
        $underReferralUser = User::where('position_id', $referByID)->get();
        foreach($underReferralUser as $userValue)
        {
            array_push($newArray, $userValue->id);
        }
        return $newArray;
    }

    private function referralCommission($userId, $planId)
    {
    	$user = User::find($userId);
    	$plan = Plan::find($planId);
    	if($user)
    	{
    		if($user->ref_by != null)
    		{
    			$referral = User::find($user->ref_by);
    			$referral->balance += $plan->referral_bonus;
    			$referral->save();

    			$transaction = new Transaction();
		        $transaction->user_id = $referral->id;
		        $transaction->amount = $plan->referral_bonus;
		        $transaction->post_balance = $referral->balance;
		        $transaction->trx_type = '+';
		        $transaction->details = 'Referral commission from '. $user->username;
		        $transaction->trx = getTrx();
		        $transaction->save();

		        $commission = new Commissions();
                $commission->user_id = $referral->id;
                $commission->from_user_id = $user->id;
                $commission->amount = $plan->referral_bonus;
                $commission->post_balance = $referral->balance;
                $commission->trx = $transaction->trx;
                $commission->mark = 1;
                $commission->details = 'Referral commission from ' . $user->username;
                $commission->save();

                notify($referral, 'REFERRAL_COMMISSION', [
		            'trx' => $commission->trx,
		            'amount' => getAmount($plan->referral_bonus),
		            'currency' => $this->general()->cur_text,
		            'post_balance' => getAmount($referral->balance),
		        ]);

                $adminNotification = new AdminNotification();
                $adminNotification->user_id = $user->id;
                $adminNotification->title = 'Referral commission successful';
                $adminNotification->click_url = urlPath('admin.report.commissions');
                $adminNotification->save();
    		}
    	}
    }

    private function levelCommission($userId, $planId, $amount)
    {
        $user = User::find($userId);
        $plan = Plan::find($planId);
        $userInfo = $userId;
        $value = 1;

        while($userInfo != "0" || $userInfo != "0" || $value <= $this->general()->matrix_height)
        {
            $myInfo = User::find($userInfo);
            if($this->userValid($myInfo->position_id) == false)
            {
                break;
            }
            $referral = $this->userValid($myInfo->position_id);
            if($value <= $this->general()->matrix_height)
            {

                $commission = $plan->level->where('level', $value)->first();
                if(!$commission){
                    break;
                }

                $percentInDecimal = $commission->amount / 100;
                $percentAmount = $percentInDecimal * $amount;

                //tax percent
                $taxamount= 0;
                if($plan->tax > 0){
                    if($taxamount  > 0){
                        $taxamount = $plan->tax;
                    }else{
                        $taxamount = 5;
                    }
                    
                    $taxPercentInDecimal = $taxamount / 100;
                    $percentAmountWithTaxApply = $taxPercentInDecimal * $percentAmount;
                    $percentAmountWithTaxApplied = $percentAmount - $percentAmountWithTaxApply;
                }else{
                    $percentAmountWithTaxApplied = 0;
                }
               

                $referral->balance += $percentAmountWithTaxApplied;
                $referral->save();

                $transaction = new Transaction();
                $transaction->user_id = $referral->id;
                $transaction->amount = $percentAmountWithTaxApplied;
                $transaction->post_balance = $referral->balance;
                $transaction->trx_type = '+';
                $transaction->details = 'Level '. $value. ' commission from ' .$user->username. " (Tax applied ".$plan->tax."%)" ;
                $transaction->trx = getTrx();
                $transaction->save();

                $comm = new Commissions();
                $comm->user_id = $referral->id;
                $comm->from_user_id = $user->id;
                $comm->level = $value;
                $comm->amount = $percentAmountWithTaxApplied;
                $comm->post_balance = $referral->balance;
                $comm->trx = $transaction->trx;
                $comm->mark = 2;
                $comm->details = 'Level '.$value.' commission from ' . $user->username . " (Tax applied ".$plan->tax."%)";
                $comm->save();

                notify($referral, 'LEVEL_COMMISSION', [
                    'trx' => $comm->trx,
                    'amount' => getAmount($percentAmountWithTaxApplied),
                    'currency' => $this->general()->cur_text,
                    'post_balance' => getAmount($referral->balance),
                ]);
            }
            $userInfo = $referral->id;
            $value++;
        }
    }

    private function userValid($userId){
        $user = User::find($userId);
        return $user ? $user:false;
    }

    private function general()
    {
        return GeneralSetting::first();
    }

}
