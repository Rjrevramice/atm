@extends($activeTemplate.'layouts.auth')
@section('content')
@php
    $policys = getContent('policy_pages.element', false, null, true);
@endphp

<!-- style="background-image: url('{{ getImage('assets/images/frontend/auth/'.getContent('auth.content',true)->data_values->image) }}');" -->
<section class="account-section style--two bg_light">
    <div class="left p-4 w-100">
        <div class="left-inner text-center">
            <!-- <h6 class="text--base">@lang('Welcome back')</h6> -->
            <h3 class="title black mt-2">@lang('Sign Up to your account')</h3>
        </div>
        <div class="row d-flex justify-content-center mt-3">
        <div class="col-md-10 col-lg-8 col-xl-6">
        <div class="right card border-0 br_10 h-100 p-md-4 p-3 bs_1 w-100">
        <div class="top w-100 text-center">
            <a href="{{route('home')}}" class="account-logo"><img src="{{getImage(imagePath()['logoIcon']['path'] .'/logo.png')}}" alt="@lang('logo')"></a>
        </div>
        <div class="middle w-100">
        <form action="{{ route('user.register') }}" method="POST" onsubmit="return submitUserForm();" class="contact-form row mb--25 align-items-center">
            @csrf
                    

                <div class="col-md-6">
                    <div class="contact-form-group">
                        <label for="firstname">@lang('Name')<span class="pl-1 text-danger">*</span></label>
                        <input type="text" placeholder="@lang(' Name')" id="firstname" value="{{old('firstname')}}" required name="firstname">
                    </div>
                </div>

                <!-- <div class="col-md-6">
                    <div class="contact-form-group">
                        <label for="lastname">@lang('Last Name')<span class="pl-1 text-danger">*</span></label>
                        <input type="text" placeholder="@lang('Last Name')" id="lastname" value="{{old('lastname')}}" required name="lastname">
                    </div>
                </div> -->

                <div class="col-md-6">
                    <div class="contact-form-group">
                        <label for="email">@lang('Email Address')<span class="pl-1 text-danger">*</span></label>
                        <input type="email" placeholder="@lang('Email Address')" id="email" class="checkUser" value="{{old('email')}}" required name="email">
                    </div>
                </div>

                <div class="col-md-6 d-none">
                    <div class="contact-form-group">
                        <label for="username">@lang('Username')<span class="pl-1 text-danger">*</span></label>
                        <input type="text" placeholder="@lang('Username')" id="username" class="checkUser" value="{{ 'OFC'.random_int(100000, 999999) }}" required name="username">
                    </div>
                </div>

                <div class="col-md-6">
                     <div class="contact-form-group">
                        <label for="country">{{__('Country')}}<span class="pl-1 text-danger">*</span></label>
                        <div class="select-item">
                            <select name="country" id="country" class="select-bar">
                                @foreach($countries as $key => $country)
                                    <option data-mobile_code="{{ $country->dial_code }}" value="{{ $country->country }}" data-code="{{ $key }}">{{ __($country->country) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="contact-form-group">
                        <label for="mobile">@lang('Mobile')<span class="pl-1 text-danger">*</span></label>
                        <div class="input-group ">
                            <div class="input-group-prepend">
                                <span class="input-group-text mobile-code">
                                </span>
                                <input type="hidden" name="mobile_code">
                                <input type="hidden" name="country_code">
                            </div>
                            <input type="text" name="mobile" id="mobile" value="{{ old('mobile') }}" class="form-control checkUser" placeholder="@lang('Your Phone Number')">
                        </div>
                        <small class="text-danger mobileExist"></small>
                    </div>
                </div>

                 <!-- <div class="col-md-6">
                    <div class="contact-form-group">
                        <label for="pin">@lang('Enter Pin')<span class="pl-1 text-danger">*</span></label>
                        <input type="text" placeholder="@lang('Pin')" id="pin" value="{{old('pin')}}" required name="pin">
                    </div>
                </div> -->
            

                <div class="col-md-6">
                    <div class="contact-form-group">
                        <label for="password">@lang('Password')<span class="pl-1 text-danger">*</span></label>
                        <div class="hover-input-popup">
                            <input type="password" placeholder="@lang('Enter Password')" id="password" required name="password">
                            @if($general->secure_password)
                                <div class="input-popup">
                                    <p class="error lower">@lang('1 small letter minimum')</p>
                                    <p class="error capital">@lang('1 capital letter minimum')</p>
                                    <p class="error number">@lang('1 number minimum')</p>
                                    <p class="error special">@lang('1 special character minimum')</p>
                                    <p class="error minimum">@lang('6 character password')</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="contact-form-group">
                        <label for="password">@lang('Confirm Password')<span class="pl-1 text-danger">*</span></label>
                        <input type="password" placeholder="@lang('Confirm Password')" id="password" required name="password_confirmation">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="contact-form-group">
                        <label for="referenceBy">@lang('Refered Code')</label>&nbsp;&nbsp;&nbsp;<span class=" font-weight-bold username_ref text-success"></span>
                        <?php 
                            $ref = "";
                            if(isset($_GET['ref'])){
                                    $ref =  $_GET['ref'];
                             }?>
                        <input type="text" name="referBy" id="referenceBy" value="{{$ref}}" >
                    </div>
                </div>
                <div class="col-md-12 mb-3">
                    @php echo loadReCaptcha() @endphp
                </div>

                @include($activeTemplate.'partials.custom_captcha')

                @if($general->agree)
                    <div class="col-md-12">
                        <div class="contact-form-group checkgroup">
                            <input type="checkbox" id="check" name="agree" required>
                            <label for="check">@lang('I agree with')
                                @foreach($policys as $policy)
                                    <a href="{{route('footer.menu', [slug($policy->data_values->menu), $policy->id])}}" class="text-theme">{{__($policy->data_values->menu)}},</a>
                                @endforeach
                            </label>
                        </div>
                    </div>
                @endif

                <div class="col-md-6 col-12 d-flex justify-content-center">
                    <!-- <div class="contact-form-group before_validate">
                        <button type="button" class="mt-3" id="validate_button">@lang('Validate PIN')</button>
                    </div> -->
                    <div class="contact-form-group after_validate" >
                        <button type="submit" class="mt-3">@lang('Create Account')</button>
                    </div>
                </div>
                <div class="col-md-6 text-md-right text-center">
                    <div class="contact-form-group">
                        <p class="black font-weight-bold m-0">@lang('Already have an account?') <a href="{{route('user.login')}}"
                                class="text-theme font-weight-bold">@lang('Sign In')</a></p>
                    </div>
                </div>
            </form>
        </div>
        <div class="bottom w-100 text-center pb-3">
            <p class="font-weight-bold black">&copy; @lang('All Right Reserved By') <a href="{{route('home')}}" class="text-theme">{{__($general->sitename)}}</a></p>
        </div>
    </div>
        </div>
        </div>
    </div>
</section>

 <div class="modal fade custom--modal" id="existModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">@lang('You are with us')</h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <i class="fas fa-times"></i>
          </button>
        </div>
        <div class="modal-body">
            <p class="text-white">@lang('You already have an account please Sign in ')</p>
        </div>
        <div class="modal-footer">
          <a href="javascript:void(0)" class="btn btn--danger" data-dismiss="modal">@lang('Close')</button>
          <a href="{{ route('user.login') }}" class="btn btn--primary">@lang('Login')</a>
        </div>
      </div>
    </div>
  </div>
@endsection
@push('style')
<style>
    .country-code .input-group-prepend .input-group-text{
        background: #fff !important;
    }
    .country-code select{
        border: none;
    }
    .country-code select:focus{
        border: none;
        outline: none;
    }
    .hover-input-popup {
        position: relative;
    }
    .hover-input-popup:hover .input-popup {
        opacity: 1;
        visibility: visible;
    }
    .input-popup {
        position: absolute;
        bottom: 130%;
        left: 50%;
        width: 280px;
        background-color: #1a1a1a;
        color: #fff;
        padding: 20px;
        border-radius: 5px;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        -ms-border-radius: 5px;
        -o-border-radius: 5px;
        -webkit-transform: translateX(-50%);
        -ms-transform: translateX(-50%);
        transform: translateX(-50%);
        opacity: 0;
        visibility: hidden;
        -webkit-transition: all 0.3s;
        -o-transition: all 0.3s;
        transition: all 0.3s;
    }
    .input-popup::after {
        position: absolute;
        content: '';
        bottom: -19px;
        left: 50%;
        margin-left: -5px;
        border-width: 10px 10px 10px 10px;
        border-style: solid;
        border-color: transparent transparent #1a1a1a transparent;
        -webkit-transform: rotate(180deg);
        -ms-transform: rotate(180deg);
        transform: rotate(180deg);
    }
    .input-popup p {
        padding-left: 20px;
        position: relative;
    }
    .input-popup p::before {
        position: absolute;
        content: '';
        font-family: 'Line Awesome Free';
        font-weight: 900;
        left: 0;
        top: 4px;
        line-height: 1;
        font-size: 18px;
    }
    .input-popup p.error {
        text-decoration: line-through;
    }
    .input-popup p.error::before {
        content: "\f057";
        color: #ea5455;
    }
    .input-popup p.success::before {
        content: "\f058";
        color: #28c76f;
    }
</style>
@endpush
@push('script-lib')
<script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
@endpush
@push('script')
    <script>
      "use strict";
        function submitUserForm() {
            var response = grecaptcha.getResponse();
            if (response.length == 0) {
                document.getElementById('g-recaptcha-error').innerHTML = '<span class="text-danger">@lang("Captcha field is required.")</span>';
                return false;
            }
            return true;
        }
        // $(document).on('click','#validate_button' , function(){

        //     var pin =  $('#pin').val();
    
        //     $.ajax({
        //         headers: {"X-CSRF-TOKEN": "{{ csrf_token() }}",},
        //         url:"{{ route('user.validate_pin') }}",
        //         method:"POST",
        //         data:{pin:pin},
        //         success:function(data, textStatus, statusCode)
        //         {
        //             if(statusCode.status == 200){
        //                 notify('success', data.message);
        //                 $('.before_validate').hide();
        //                 $('.after_validate').show();
        //                 $('#pin').attr("readonly",true);
        //             }
        //         },
        //         error: function(statusCode, status, error) {
        //             if(statusCode.status == 400){
        //                 notify('error', 'Pin Is Invalid');
        //             }
        //         }
        //     });
        // });
        //fetch username

        $(document).on('change','#referenceBy' , function(){
            $('.username_ref').text("");
            var pin =  $(this).val();

            $.ajax({
                headers: {"X-CSRF-TOKEN": "{{ csrf_token() }}",},
                url:"{{ route('user.fetch_username') }}",
                method:"POST",
                data:{pin:pin},
                success:function(data, textStatus, statusCode)
                {
                    if(statusCode.status == 200){
                        $('.username_ref').text(data.data);
                        $('#referenceBy').attr("readonly",true);
                        notify('success', data.message);
                    }
                },
                error: function(statusCode, status, error) {
                    if(statusCode.status == 400){
                        notify('error', 'Refer Code Is Invalid');
                    }
                }
            });
            });
        (function ($) {
            @if($mobile_code)
            $(`option[data-code={{ $mobile_code }}]`).attr('selected','');
            @endif
            $('select[name=country]').change(function(){
                $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
                $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
                $('.mobile-code').text('+'+$('select[name=country] :selected').data('mobile_code'));
            });
            $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
            $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
            $('.mobile-code').text('+'+$('select[name=country] :selected').data('mobile_code'));
            @if($general->secure_password)
                $('input[name=password]').on('input',function(){
                    secure_password($(this));
                });
            @endif

            // $('.checkUser').on('focusout',function(e){
            //     var url = '{{ route('user.checkUser') }}';
            //     var value = $(this).val();
            //     var token = '{{ csrf_token() }}';
            //     if ($(this).attr('name') == 'mobile') {
            //         var mobile = `${$('.mobile-code').text().substr(1)}${value}`;
            //         var data = {mobile:mobile,_token:token}
            //     }
            //     if ($(this).attr('name') == 'email') {
            //         var data = {email:value,_token:token}
            //     }
            //     if ($(this).attr('name') == 'username') {
            //         var data = {username:value,_token:token}
            //     }
            //     $.post(url,data,function(response) {
            //       if (response['data'] && response['type'] == 'email') {
            //         $('#existModalCenter').modal('show');
            //       }else if(response['data'] != null){
            //         $(`.${response['type']}Exist`).text(`${response['type']} already exist`);
            //       }else{
            //         $(`.${response['type']}Exist`).text('');
            //       }
            //     });
            // });

        })(jQuery);

    </script>
@endpush
