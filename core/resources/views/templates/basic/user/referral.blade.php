@extends($activeTemplate.'layouts.master')
@section('content')
@include($activeTemplate.'partials.breadcrumb')
@php $currentUser = auth()->user(); @endphp


<style>

.card{
        box-shadow: 0px 0px 20px #cacaff ;
        !important;
        border: none !important;
        border-radius: 10px;
    }
button{
    height: 30px !important;
    line-height: 13px !important;
    font-size: 10px !important;
}
.fa-clipboard{
    font-size: 14px !important;
}
</style>


<div class="transaction-section my-5 cart-table table-responsive">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="item-rounded  mb-2">
                    <div class="card support-header my-3">
                        <!-- <form action="{{route('user.level.position')}}" method="GET" class="support-search w-100">
                            <div class="contact-form-group">
                                <div class="select-item">
                                    <select name="level" id="level" class="select-bar">
                                        <option>-----@lang('Select Level')-----</option>
                                        @if($order)
                                            @foreach($order->plan->totalLevel($order->plan_id) as $value)
                                                <option value="{{$value->level}}">@lang('Level')-{{$value->level}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <button type="submit">@lang('Submit')</button>
                        </form> -->
                        <div class="card-body">
                            <div class="">
                                <div>
                                    <div class="row  ">
                                        <div class="col-lg-3 ">
                                            <p><b>My Referral Code:</b></p>
                                        </div>
                                        <div class="col-lg-7 mt-lg-0 mt-2 col-8">
                                            {{$currentUser->my_refer_code}}
                                        </div>
                                        <div class="col-lg-2 mt-lg-0 mt-2 text-center col-4">
                                            <button id="copyButton" class="btn btn-primary" onclick="copyToClipboard()">
                                                <i class="far fa-clipboard"></i> Copy
                                            </button>
                                        </div>
                                       
                                    </div>
                                    <hr>
                                    <div class="row mt-4">
                                        <div class="col-lg-3 ">
                                            <p><b>My Referral Link:</b></p>
                                        </div>
                                        <div class="col-lg-7 mt-lg-0 mt-2 col-8">
                                            {{route('user.register',['ref'=>$currentUser->my_refer_code])}} 
                                        </div>
                                        <div class="col-lg-2 mt-lg-0 mt-2 text-center col-4">
                                            <button id="copyButton" class="btn btn-primary" onclick="copyToLink('{{ route('user.register', ['ref' => $currentUser->my_refer_code]) }}')">
                                                <i class="far fa-clipboard"></i> Copy
                                            </button>
                                        </div>
                                       
                                    </div>
                                  

                                </div>
                            </div>
                        </div>

                    </div>
                    
                   
                   <div class="card">
                        <div class="card-body p-0 m-0">
                            <table class="deposite-table table table-bordered m-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>@lang('ID')</th>
                                        <th>@lang('Name')</th>
                                        <th>@lang('Email')</th>
                                        <!-- <th>@lang('Balance')</th> -->
                                        <th>@lang('Joined At')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($referrals as $referral)
                                        <tr>
                                            <td data-label="@lang('ID')" >{{$loop->iteration}}</td>
                                            <td data-label="@lang('Username')">{{$referral->firstname}}</td>
                                            <td data-label="@lang('Email')">{{$referral->email}}</td>
                                            <!-- <td data-label="@lang('Balance')">{{getAmount($referral->balance)}} {{$general->cur_text}}</td> -->
                                            <td data-label="@lang('Joined At')">
                                                {{showDateTime($referral->created_at)}}
                                                <br>
                                                {{diffforhumans($referral->created_at)}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div>
                            {{$referrals->links()}}
                        </div>
                   </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function copyToClipboard() {
        const referralCode = '{{$currentUser->my_refer_code}}'; // Get the referral code
        const textArea = document.createElement('textarea');
        textArea.value = referralCode;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand('copy');
        document.body.removeChild(textArea);
        notify('success', "Referral code copied to clipboard");
    }
    function copyToLink(e){
       const textArea = document.createElement('textarea');
       textArea.value = e;
       document.body.appendChild(textArea);
       textArea.select();
       document.execCommand('copy');
       document.body.removeChild(textArea);
       notify('success', "Referral link copied to clipboard");
    }
</script>

@endsection
