@extends($activeTemplate.'layouts.master')
@section('content')
@include($activeTemplate.'partials.breadcrumb')

<style>
    .contact-form-group button{

        background-color: #4e4eff !important;

    }
</style>

    <section class="profile-section my-5">
        <div class="container">
            <div class="item-rounded bs_1  profile-wrapper align-items-start">
                <div class="profile-user mb-lg-0 bs_1">
                    <div class="thumb">
                        <img src="{{getImage('assets/images/user/profile/'.auth()->user()->image, '400x400')}}" alt="@lang('user')">
                        <b class="text-dark">Id:</b><span class="text-dark">{{auth()->user()->my_refer_code}}</span>
                    </div>
                    <div class="content">
                        
                        <h6 class="title black" style="color:black">@lang('Email Address') : {{__($user->email)}}</h6>
                        <!-- <div class="subtitle black">@lang('Username') : {{__($user->username)}}</div> -->
                        <div class="subtitle black">@lang('Phone Number') : {{__($user->mobile)}}</div>
                        <div class="subtitle black">@lang('Country') : {{__(@$user->address->country)}}</div>
                    </div>
                </div>
                <div class="profile-form-area">
                    <form class="profile-edit-form row mb--25" action="" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="contact-form-group col-md-6">
                            <label for="first-name">@lang('Name')</label>
                            <input type="text" id="first-name" name="firstname" value="{{__($user->firstname)}}" required="">
                        </div>
                        <!-- <div class="contact-form-group col-md-6">
                            <label for="last-name">@lang('Last Name')</label>
                            <input type="text" id="last-name" name="lastname" value="{{__($user->lastname)}}" required="">
                        </div> -->
                     
                        <div class="contact-form-group col-md-6">
                            <label for="address">@lang('Address')</label>
                            <input type="text" id="address" name="address" placeholder="@lang('Enter Address')" value="{{__(@$user->address->address)}}" required="">
                        </div>

                        <div class="contact-form-group col-md-6">
                            <label for="city">@lang('City')</label>
                            <input type="text" id="city" name="city" placeholder="@lang('Enter City')" value="{{__(@$user->address->city)}}" required="">
                        </div>

                        <div class="contact-form-group col-md-6">
                            <label for="state">@lang('State')</label>
                            <input type="text" id="state" name="state" placeholder="@lang('Enter State')" value="{{__(@$user->address->state)}}" required="">
                        </div>

                        <div class="contact-form-group col-md-6">
                            <label for="zip">@lang('Zip')</label>
                            <input type="text" id="zip" name="zip" placeholder="@lang('Enter Zip')" value="{{__(@$user->address->zip)}}" required="">
                        </div>
                        <!-- <div class="contact-form-group col-md-6">
                            <label for="aname">@lang('Account Holder Name')</label>
                            <input type="text" id="acc_name" name="acc_name" placeholder="@lang('Enter Acc Holder Name')" value="{{__(@$user->address->acc_name)}}" required="">
                        </div>

                        <div class="contact-form-group col-md-6">
                            <label for="anumber">@lang('Account Holder Number')</label>
                            <input type="text" id="acc_no" name="acc_no" placeholder="@lang('Enter Acc Holder Name')" value="{{__(@$user->address->acc_no)}}" required="">
                        </div>

                        <div class="contact-form-group col-md-6">
                            <label for="bname">@lang('Branch Name')</label>
                            <input type="text" id="br_name" name="br_name" placeholder="@lang('Enter Branch Name')" value="{{__(@$user->address->br_name)}}" required="">
                        </div>

                        <div class="contact-form-group col-md-6">
                            <label for="ifsc">@lang('IFSC code')</label>
                            <input type="text" id="ifsc" name="ifsc" placeholder="@lang('Enter IFSC code')" value="{{__(@$user->address->ifsc)}}" required="">
                        </div> -->

                        <div class="contact-form-group col-md-12">
                            <label for="file">@lang('Change Profile Picture')</label>
                            <input type="file" id="file" name="image">
                        </div>

                        <div class="contact-form-group w-100 col-md-6">
                            <button type="submit">@lang('Update Profile')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
