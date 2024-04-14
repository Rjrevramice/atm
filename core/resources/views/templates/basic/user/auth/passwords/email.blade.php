@extends($activeTemplate.'layouts.auth')
@section('content')
<!-- style="background-image: url('{{ getImage('assets/images/frontend/auth/'.getContent('auth.content',true)->data_values->image) }}');" -->

<section class="account-section bg_light">
    <div class="left p-3" >
        <div class="left-inner text-center">
            <h3 class="title black mt-2">@lang('Reset Password')</h3>
        </div>
        <div class="row d-flex justify-content-center mt-3">
        <div class="col-md-7 col-lg-5 col-xl-4">
        <div class="right card border-0 br_10 h-100 p-md-4 p-3 bs_1">
        <div class="top w-100 text-center">
            <a href="{{route('home')}}" class="account-logo"><img src="{{getImage(imagePath()['logoIcon']['path'] .'/logo.png')}}" alt="@lang('logo')"></a>
        </div>
        <div class="middle w-100">
            <form action="{{ route('user.password.email') }}" method="POST" class="contact-form row mb--25 align-items-center">
                @csrf
                <div class="col-md-12">
                     <div class="contact-form-group">
                        <label for="type">{{__('Select One')}}</label>
                        <div class="select-item">
                            <select name="type" id="type" class="select-bar">
                                <!--<option value="email">@lang('E-Mail Address')</option>-->
                                <option value="username">@lang('Username')</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="contact-form-group">
                        <label class="my_value"></label>
                        <input type="text" class="@error('value') is-invalid @enderror"  value="{{old('username')}}" name="value" value="{{ old('value') }}" required autofocus="off">
                    </div>
                </div>

                <div class="col-md-12 pt-3 d-flex justify-content-center align-items-center">
                    <div class="contact-form-group">
                        <button type="submit">@lang('Send Password Code')</button>
                    </div>
                </div>
                <div class="col-12 d-flex justify-content-start">
                        <div class="contact-form-group">
                            <p class="font-weight-bold black m-0">@lang("Back to?") <a href="{{route('user.login')}}"
                                    class="text-theme">@lang('login')</a></p>
                        </div>
                    </div>
            </form>
        </div>
        <div class="bottom w-100 text-center pb-3">
            <p class="font-weight-bold black">&copy; @lang('All Right Reserved By') <a href="{{route('home')}}" class="text-theme font-weight-bold">{{__($general->sitename)}}</a></p>
        </div>
    </div>
    </div>
    </div>
    </div>

   
</section>
@endsection
@push('script')
<script>

    (function($){
        "use strict";
        
        myVal();
        $('select[name=type]').on('change',function(){
            myVal();
        });
        function myVal(){
            $('.my_value').text($('select[name=type] :selected').text());
        }
    })(jQuery)
</script>
@endpush