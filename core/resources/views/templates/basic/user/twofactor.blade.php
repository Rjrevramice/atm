@extends($activeTemplate.'layouts.master')
@section('content')
@include($activeTemplate.'partials.breadcrumb')





    <style>
        .contact-form-group label{
            
        }
        .profile-card{
            padding: 60px;
            background-color: aliceblue;
            /* border-radius: 0px 0px 20px 20px  !important; */
        }
        .c-head{
            background: #7979fc !important;
            padding: 15px !important; 
            /* border-radius: 15px 15px 0px 0px !important; */
        }
        .custom--card.primary-bg{
            /* background: white !important; */
        }
        .card{
            box-shadow: 0px 0px 50px #d2d2ff;
        }
        .card-bodyy,.card{
            /* border-radius: 0px 0px 20px 20px  !important; */

        }
        .contact-form-group input{
            box-shadow: rgb(184 184 184 / 24%) 0px 3px 20px !important;
            border: none !important;
        }
        .Update-btn{
            background-color: #7979fc  !important;
            opacity: 1 !important;
        }
    </style>




    <div class="two-section padding-top padding-bottom">
        <div class="container">
            <div class="row mb-30-none justify-content-center">
                <div class="col-lg-8">
                    <div class="card custom--card primary-bg h-100">
                        <div class="card-header c-head">
                            <h5 class="card-title">@lang('Account Details')</h5>
                        </div>
                        <div class="card-bodyy">
                            <div class="profile-card">
                                <form class="profile-edit-form row mb--25" action="{{route('user.account_save')}}" method="post" enctype="multipart/form-data">
                                    @csrf
            
                                    
                                    <div class="contact-form-group col-md-6">
                                            <label for="aname">@lang('Account Holder Name')</label>
                                        <input type="text" id="acc_name" name="acc_name" placeholder="@lang('Enter Acc Holder Name')" value="{{__(@$user->acc_holder_name)}}" required="">
                                    </div>
            
                                    <div class="contact-form-group col-md-6">
                                        <label for="anumber">@lang('Account Holder Number')</label>
                                        <input type="text" id="acc_no" name="acc_no" placeholder="@lang('Enter Acc Holder Number')" value="{{__(@$user->acc_holder_number)}}" required="">
                                    </div>
                                    <div class="contact-form-group col-md-6">
                                        <label for="anumber">@lang('Upi Id')</label>
                                        <input type="text" id="upi_id" name="upi_id" placeholder="@lang('Enter upi id')" value="{{__(@$user->upi_id)}}" >
                                    </div>
            
                                    <div class="contact-form-group col-md-6">
                                        <label for="bname">@lang('Branch Name')</label>
                                        <input type="text" id="br_name" name="br_name" placeholder="@lang('Enter Branch Name')" value="{{__(@$user->br_name)}}" required="">
                                    </div>
            
                                    <div class="contact-form-group col-md-12">
                                        <label for="ifsc">@lang('IFSC code')</label>
                                        <input type="text" id="ifsc" name="ifsc" placeholder="@lang('Enter IFSC code')" value="{{__(@$user->ifsc)}}" required="">
                                    </div>
            
                                    <div class="contact-form-group w-100 col-md-12 mt-4">
                                        <button type="submit" class="btn   Update-btn">@lang('Update Details')</button>
                                    </div>
                                </form>
                            </div>
                           
                        </div>
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


