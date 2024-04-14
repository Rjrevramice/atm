@extends($activeTemplate.'layouts.auth')
@section('content')

<!-- style="background-image: url('{{ getImage('assets/images/frontend/auth/'.getContent('auth.content',true)->data_values->image) }}');" -->
<section class="account-section bg_light">
    <div class="left p-3">
        <div class="left-inner text-center">
            <!-- <h6 class="text--base">@lang('Welcome back')</h6> -->
            <h3 class="title black mt-2">@lang('Sign In to your account')</h3>
        </div>
        <div class="row d-flex justify-content-center mt-3">
        <div class="col-md-7 col-lg-5 col-xl-4">
        <div class="right card border-0 br_10 h-100 p-md-4 p-3 bs_1">
        <div class="top w-100 text-center">
            <a href="{{route('home')}}" class="account-logo"><img src="{{getImage(imagePath()['logoIcon']['path'] .'/logo.png')}}" alt="@lang('logo')"></a>
        </div>
        <div class="middle w-100">
            <form method="POST" action="{{ route('user.login')}}" onsubmit="return submitUserForm();" class="contact-form row mb--25 align-items-center">
                @csrf
                    <div class="col-md-12">
                        <div class="contact-form-group">
                            <label for="username">@lang('Email')<sapn class="pl-1 text-danger">*</sapn></label>
                            <input type="text" placeholder="@lang('Enter Email')" value="{{old('phone')}}" id="username" required name="email">
                        </div>
                    </div>
                    <!-- <div class="col-md-12">
                        <div class="contact-form-group">
                            <label for="username">@lang('Phone')<sapn class="pl-1 text-danger">*</sapn></label>
                            <input type="text" placeholder="@lang('Enter Phone Number')" value="{{old('phone')}}" id="username" required name="mobile">
                        </div>
                    </div> -->
                    <div class="col-md-12">
                        <div class="contact-form-group">
                            <label for="password">@lang('Your Password')<sapn class="pl-1 text-danger">*</sapn></label>
                            <input type="password" placeholder="@lang('Enter Password')" id="password" required name="password">
                        </div>
                    </div>

                    <div class="col-md-12 mb-3">
                        @php echo loadReCaptcha() @endphp
                    </div>

                    @include($activeTemplate.'partials.custom_captcha')
                
                    <div class="col-md-12">
                        <div class="contact-form-group">
                            <button type="submit" class="w-100">@lang('Sign In')</button>
                        </div>
                    </div>
                    <div class="col-xl-8">
                        <div class="contact-form-group">
                            <p class="font-weight-bold black m-0">@lang("You Don'\t have an account?") <a href="{{route('user.register')}}"
                                    class="text-theme font-weight-bold">@lang('Sign Up')</a></p>
                        </div>
                    </div>

                   <div class="col-xl-4 text-xl-right">
                      <div class="contact-form-group">
                      <a href="{{route('user.password.request')}}" class="text-theme font-weight-bold">@lang('Forgot Password')</a>
                     </div>
                    </div>
                </form>
        </div>
        <div class="bottom w-100 text-center">
            <p class="font-weight-bold black">&copy; @lang('All Right Reserved By') <a href="{{route('home')}}" class="text--base text-theme font-weight-bold">{{__($general->sitename)}}</a></p>
        </div>
    </div>
        </div>
    </div>
    </div>
</section>
@endsection

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
    </script>
@endpush
