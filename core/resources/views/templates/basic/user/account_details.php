@extends($activeTemplate.'layouts.master')
@section('content')
@include($activeTemplate.'partials.breadcrumb')
    <div class="two-section padding-top padding-bottom">
        <div class="container">
            <div class="row mb-30-none">
                <div class="col-lg-6">
                    <div class="card custom--card primary-bg h-100">
                        <div class="card-header">
                            <h5 class="card-title">@lang('Account Details')</h5>
                        </div>
                        <form class="profile-edit-form row mb--25" action="" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="contact-form-group col-md-6">
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
                        </div>

                        <div class="contact-form-group w-100 col-md-6">
                            <button type="submit">@lang('Update Details')</button>
                        </div>
                    </form>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        (function($){
            "use strict";
            $('.copytext').on('click',function(){
                var copyText = document.getElementById("referralURL");
                copyText.select();
                copyText.setSelectionRange(0, 99999);
                document.execCommand("copy");
                iziToast.success({message: "Copied: " + copyText.value, position: "topRight"});
            });
        })(jQuery);
    </script>
@endpush


