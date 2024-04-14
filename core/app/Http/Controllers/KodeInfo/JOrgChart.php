<?php

namespace App\Http\Controllers\KodeInfo;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;

class JOrgChart
{

    public $chain = [];
    public $tree_string = "";

    public function getChart($referral_id)
    {

        $users = DB::table('users')->where('ref_by', $referral_id)->where('id', '>', 0)->pluck('id');

        $this->chain[$referral_id] = $users;

        //[1]=>[2 ,3]
        $this->recursiveTree($users, $this->chain[$referral_id], $count=0);
       
        return ['tree_array' => $this->chain, 'tree_string' => $this->tree_string];
    }

    public function recursiveTree($referral_ids, &$arr, $count)
    {
        $count++;

        $this->tree_string .= "<ul>";

        // [1]=>[2,3] $arr is at [1]
        for ($i = 0; $i < sizeof($referral_ids); $i++) {
            
            //index 2
            $referrals = DB::table('users')->where('ref_by', $referral_ids[$i])->where('id', '>', 0)->pluck('id');
            
            //index 2 users 4,5
            //by reference on 2 nd array
            $find_user = DB::table('users')->where('id', $arr[$i])->first();

            
            $this->tree_string .= "<li title='This is tooltip for user $find_user->firstname'><label>$find_user->firstname</label>";
            // unset($arr[$i]);

            // $arr[$referral_ids[$i]] = $referrals;
           
            if($count < 5){
                if (sizeof($referrals) > 0) {
                    //[2]=>[4,5] reference [2]=>
                    $this->recursiveTree($referrals, $referrals , $count);
                }
            }
            

            $this->tree_string .= "</li>";

        }
        $this->tree_string .= "</ul>";
    }
} 