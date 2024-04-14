@extends($activeTemplate . 'layouts.master')
@section('content')
    @include($activeTemplate . 'partials.breadcrumb')
    @php
        $policys = getContent('policy_pages.element', false, null, true);
    @endphp
    <div class="dashboard-section my-5 py-md-5">
        <div class="container">


        <style>

            .provide-title{
                min-width: 130px;
            }

            .reff{
                border-radius: 10px;
                border: 3px double #cdcdff;
            }
            .re-box h5{
                font-weight: 200;
                font-size: 20px;
                text-align: center;
            }
            .re-box p{
                font-size: 15PX;
                margin: 0 !important;
                font-weight: 300;
                letter-spacing: 2px;
                color: blue;
                text-align: center;

            }
            .dashboard-item{
                cursor: pointer;
            }

            .dashboard-item:hover{
                background-color: #75a1fb;
            }

            .dashboard-item:hover .provide-title{
                color: white;
            }

            .dashboard-item:hover .dash-icon{
                background-color: white !important;
            }
            .dashboard-item:hover .dash-icon i{
                color: #75a1fb !important ;
            }

            .dash-icon{
                background-color: #75a1fb !important;
            }

            .next1 {
                /* padding: 0px 20px !important;
                height: 30px; */
                margin: 6px 18px 20px 18px;

            }

            #exampleModalLabel, #exampleModalLongTitle{
                font-size: 20px;
            }

            .contact-form-group{
                margin: 28px 0px;
            }

            #currency,#amount{
                padding: 20px;
            }
            .b-n{
                margin-top: 15px;
            }

            table tr td{
                color: white !important;
            }

       

        </style>


            <div class="row justify-content-center">

                <div class="col-12 mb-md-12 mb-3">

                    <div class="card bs_1 reff" style="border-radius: 10px;">
                        <div class="card-body">
                            <div class="normal-text re-box">
                                <h5 > My Refferal Code </h5>
                                 <p>{{auth()->user()->my_refer_code}}</p>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-sm-6 mb-md-4 mb-3">
                    <a data-toggle="modal" data-target="#exampleModal" class="w-100">
                        <div class="dashboard-item card border-0 h-100 p-md-4 mb-0 bs_1 p-3 w-100">
                            <div class="card-body p-0 d-flex justify-content-center align-items-center">
                                <div class="media align-items-center">
                                    <div class="dash-icon">
                                        <i class="las la-shopping-cart "></i>
                                    </div>
                                    <div class="media-body">

                                        <h6 class="title mt-0 provide-title">Provide Help</h6>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>



                <div class="col-sm-6 mb-md-4 mb-3">
                    <a data-toggle="modal" data-target="#exampleModalCenter" class="w-100">
                        <!-- <a href="#" class="w-100"> -->
                        <div class="dashboard-item card border-0 h-100 p-md-4 mb-0 bs_1 p-3">
                            <div class="card-body p-0 d-flex justify-content-center align-items-center">
                                <div class="media align-items-center">
                                    <div class="dash-icon">
                                        <i class="lar la-newspaper"></i>
                                    </div>
                                    <div class="media-body">
                                        <h6 class="title mt-0 provide-title">Get Help</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- </a> -->
                    </a>
                </div>
                <!-- <div class="col-md-4 mb-md-4 mb-3">
                        <a href="{{ route('user.profile.setting') }}" class="w-100">
                            <div class="dashboard-item card border-0 h-100 p-md-4 mb-0 bs_1 p-3">
                                <div class="card-body p-0 d-flex justify-content-center align-items-center">

                                    <div class="media align-items-center">
                                        <div class="dash-icon">
                                        <i class="las la-user"></i>
                                        </div>
                                        <div class="media-body">
                                            <h6 class="title mt-0">My Profile</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div> -->
                <!-- Modal -->
                <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Get Help</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('user.save_get_help') }}" method="POST">
                                    @csrf
                                    <div>
                                        <label for=""> <b>Currency</b> </label>
                                        <select name="currency" id="" class="form-control">
                                            <option value="INR">INR</option>
                                            <option value="USD">USD</option>
                                        </select>
                                        <span></span>
                                        
                                    </div>
                                    <div class="mt-2">
                                        <label for=""> <b>Amount</b></label>
                                        <input type="number" name="amount" id="getAmount" class="form-control">
                                    </div>
                                    <div>
                                        <small> <b>Available Amount: 1000</b></small>
                                        <input type="hidden" id="availAmount" value="1000">
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" id="saveOrderButton"
                                    onclick= "checkAmount()">Save Order</button>
                            </div>
                            </form>

                        </div>
                    </div>
                </div>

                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Add Request</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{ route('user.provide_help') }}" method="post" id="form">
                                @csrf
                                <div class="tab-content " id="myTabContent">
                                    <div class="tab-pane fade show active" id="warning" role="tabpanel">
                                        <div class="col-md-12">
                                            <div class="contact-form-group checkgroup">
                                                <input type="checkbox" id="check" name="agree" required>
                                                <label for="check">@lang('I agree with')
                                                    @foreach ($policys as $policy)
                                                        <a href="{{ route('footer.menu', [slug($policy->data_values->menu), $policy->id]) }}"
                                                            class="text-theme">{{ __($policy->data_values->menu) }},</a>
                                                    @endforeach
                                                    I fully understand all the risks.I make decision to participate in
                                                    {{ $general->sitename }},being of sound mind and memory.
                                                </label>
                                            </div>
                                            <button type="button" class="btn btn-primary nextBtn next1">Next</button>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade " id="currency" role="tabpanel">
                                       
                                        <div class="mb-3">
                                            <label for=""><b>Currency you want provide assistancy in,</b></label>
                                            <select name="" id="" class="form-control">
                                                <option value="">Select Currency</option>
                                                <option value="INR">{{ $general->sitename }}-INR</option>
                                            </select>
                                            <small class="text-muted">Specify Currency, which you are ready to work in the system.</small>
                                        </div>
                                        
                                        
                                       
                                       <div class="mb-4">
                                        <label for=""><b>Currency</b></label>
                                        <select name="currency" id="" class="form-control">
                                            <option value="">Select Currency</option>
                                            <option value="INR">INR</option>
                                        </select>
                                        
                                        <small class="text-muted">If you could not find your Currency in the list provided.Please, choose at the
                                            list on top.</small>
                                       </div>

                                        <div class="b-n">
                                            <button type="button" class="btn btn-secondary prevBtn back1">Back</button>
                                            <button type="button" class="btn btn-primary nextBtn next2">Next</button>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade " id="amount" role="tabpanel">
                                       
                                        <div>
                                            <label for="">Amount</label>
                                            <input type="number" name="amount" placeholder="Enter the amount"  value="" required>
                                        </div>

                                       
                                        <div class="mt-3">
                                            <label for="">Growing Rate</label>
                                            <select name="return_percentage" id="">
                                                <option value="20">20%</option>
                                                <option value="30">30%</option>
                                                <option value="50">50%</option>
                                            </select>
                                        </div>

                                        <div class="mt-3">
                                            <small class="" style="line-height: 20px;display: inline-block;">
                                                1.From 1000 to 5000 INR,Get growth(30% monthly, 1% daily),No Locking
                                                period.Growth will start after conform primary link.
                                            </small>
                                            <br>
                                            <small class="" style="line-height: 20px;display: inline-block;margin-top: 14px;">
                                                2.From 5000 to 10000 INR,Get growth(45% monthly, 1.5% daily),No Locking
                                                period.Growth will start after conform primary link.
                                            </small>
                                            <br>
                                            <small class="" style="line-height: 20px;display: inline-block;margin-top: 14px;">
                                                3.From 10000 to 50000 INR,Get growth(50% monthly, 2% daily),No Locking
                                                period.Growth will start after conform primary link.
                                            </small>
                                        </div>


                                        <div class="mt-4">
                                            <button type="button" class="btn btn-secondary prevBtn">Back</button>
                                            <button type="submit" class="btn btn-primary ">Save Order</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- <div class="">
                        <h4>Your Requests</h4>
                    </div> -->
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Date of Created</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Token</th>
                                <th scope="col">Time</th>
                                <th scope="col">Status</th>
                                <th scope="col">View</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i= 1;@endphp
                            @foreach ($helps as $help)
                                <tr
                                    style="background-color: {{ $help->help_type === 'provide_help' ? '#4e4eff' : ($help->help_type === 'get_help' ? 'orange' : 'white') }}">
                                    <th scope="row">
                                        <div>
                                            @if ($help->match_id !== null)
                                                <div
                                                    class="circle @if ($help->proof !== null) full-dark-green @elseif ($help->match_id !== null) half-dark-green @endif">
                                                    <div class="tick-mark"></div>
                                                </div>
                                            @endif
                                        </div>{{ $i++ }}
                                    </th>
                                    <td>{{ $help->created_at }}</td>
                                    <td>{{ number_format($help->amount, 2) }}-{{ $help->currency }}</td>
                                    <td><span class="badge badge-pill badge-secondary">{{ $help->current_token }}</span>
                                    </td>
                                    <td><span class="badge badge-pill badge-secondary"><span class="countdown"
                                                data-creation-time="{{ strtotime($help->created_at) * 1000 }}"></span></span>
                                    </td>



                                    <td><?= $help->status == 0 ? 'Not yet Approved' : 'Approved' ?>


                                        <div>
                                            <button class="btn btn-secondary btn-sm btn-rounded cancel-button"
                                                style="height: 30px;"
                                                data-created-time="{{ strtotime($help->created_at) * 1000 }}"
                                                data-button-id="cancelButton_{{ $help->id }}"
                                                data-target="#cancel-alert{{ $help->id }}"
                                                data-toggle="modal">Cancel</button>
                                        </div>
                                        <!--  -->
                                    </td>

                                    <div class="modal fade" id="cancel-alert<?= $help->id ?>" tabindex="-1"
                                        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Cancel this Help</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to delete this help?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-danger"
                                                        data-id="<?= $help->id ?>" id="delete-help">Delete</button>
                                                </div>
                                            </div>
                                        </div>
                                        <td>
                                            @if (isset($help->match_id))
                                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                                    data-target="#exampleModalLong_{{ $help->id }}">
                                                    View Details
                                                </button>
                                            @endif

                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModalLong_{{ $help->id }}"
                                                tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header details-header">
                                                            <h5 class="modal-title" id="exampleModalLongTitle">Details
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            @if (isset($help->match_id))
                                                                @php
                                                                    $getUserId = App\Models\Help::where('id', $help->match_id)->first();
                                                                    $getUser = App\Models\User::where('id', $getUserId->user_id)->first();
                                                                @endphp

                                                                @if ($help->help_type === 'provide_help')
                                                                    <div><b class="mr-2">Account Holder
                                                                            Name:</b>{{ $getUser->acc_holder_name }}</div>
                                                                    <div><b class="mr-2">Account
                                                                            Number:</b>{{ $getUser->acc_holder_number }}
                                                                    </div>
                                                                    <div><b class="mr-2">Branch
                                                                            Name:</b>{{ $getUser->br_name }}</div>
                                                                    <div><b class="mr-2">Ifsc:</b>{{ $getUser->ifsc }}
                                                                    </div>
                                                                    <div><b class="mr-2">Phone
                                                                            Number:</b>{{ $getUser->mobile }}</div>
                                                                    <div>
                                                                        <label for="">Upload transaction completed
                                                                            proof:</label>
                                                                        <input type="file" name="proof"
                                                                            id="proof" data-id="{{ $help->id }}"
                                                                            class="form-control">
                                                                        <div id="proofImg">
                                                                            <img src="<?php if (isset($help->proof)) {
                                                                                echo url('/core/public') . '/' . $help->proof;
                                                                            } ?>" alt=""
                                                                                target="_blank" width="50"
                                                                                height="50">
                                                                        </div>
                                                                    </div>
                                                                @elseif($help->help_type === 'get_help')
                                                                    <b class="mr-2">Phone
                                                                        Number:</b>{{ $getUser->mobile }}
                                                                    <?php if(isset($help->proof)){ ?>
                                                                    <div id="proofImg">
                                                                        <img src="<?php if (isset($help->proof)) {
                                                                            echo url('/core/public') . '/' . $help->proof;
                                                                        } ?>" alt=""
                                                                            target="_blank" width="50"
                                                                            height="50">
                                                                    </div>
                                                                    <div>
                                                                        <select name="getHelpAccept" id=""
                                                                            class="form-control">
                                                                            <option value="">Choose one</option>
                                                                            <option value="yes">Yes, I get the money
                                                                            </option>
                                                                            <option value="no">No, I didn't get the
                                                                                money yet</option>
                                                                        </select>
                                                                    </div>
                                                                    <?php }?>
                                                                @endif
                                                            @endif
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary close-btn"
                                                                data-dismiss="modal">Close</button>
                                                            <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                </tr>
                            @endforeach
                            <script>
                                document.addEventListener("DOMContentLoaded", function() {
                                    function updateButtonVisibility(cancelButton, createdTime) {
                                        const created_at = new Date(parseInt(createdTime));
                                        const currentTime = new Date();
                                        const diffInMinutes = Math.floor((currentTime - created_at) / (1000 * 60));

                                        if (cancelButton) {
                                            if (diffInMinutes <= 10) {
                                                cancelButton.style.display = 'block';
                                            } else {
                                                cancelButton.style.display = 'none';
                                            }
                                        }
                                    }

                                    const cancelButtons = document.querySelectorAll('.cancel-button');

                                    cancelButtons.forEach(cancelButton => {
                                        const createdTime = cancelButton.getAttribute('data-created-time');

                                        updateButtonVisibility(cancelButton, createdTime);
                                        setInterval(() => updateButtonVisibility(cancelButton, createdTime), 1000);
                                    });
                                });
                            </script>



                        </tbody>
                    </table>
                </div>
                <style>
                    .circle {
                        width: 20px;
                        height: 20px;
                        border-radius: 50%;
                        background-color: white;
                        /* Default color */
                        border: 1px solid #ccc;
                        /* Border for the circle */
                        display: inline-block;
                        position: relative;
                        /* Required for positioning the tick mark */
                    }

                    .half-dark-green {
                        background: conic-gradient(grey 0deg 180deg,
                                /* Light green for the left half */
                                #009900 180deg 360deg);
                    }

                    .full-dark-green {
                        background: #009900;
                        /* Dark green for fully filled circle */
                    }


                    .tick-mark {
                        position: absolute;
                        top: 50%;
                        left: 50%;
                        transform: translate(-50%, -50%);
                        /* Center the tick mark within the circle */
                        width: 0;
                        height: 0;
                        border-left: 5px solid transparent;
                        /* Adjust the size as needed */
                        border-top: 5px solid white;
                        /* Adjust the size and color as needed */
                        border-right: 5px solid transparent;
                        /* Adjust the size as needed */
                    }
                </style>
                <!-- <a href="{{ route('user.cart') }}"><button type="button">My Cart</button></a>
                    <a href="{{ route('user.order') }}"><button type="button">My Orders</button></a>
                    <a href="{{ route('user.profile.setting') }}"><button type="button">My Profile</button></a>  -->

                <!-- <div class="col-md-6 col-lg-4 mb-3">
                        <div class="dashboard-item card border-0 h-100 p-md-4 mb-0 bs_1 p-3">
                            <div class="card-body p-0 d-flex justify-content-center align-items-center">
                                <div class="dashboard-thumb">
                                    <i class="fas fa-money-bill"></i>
                                </div>
                                <div class="dashboard-content">
                                    <h5 class="title">@lang('Current Balance')</h5>
                                    <h4 class="amount">{{ $general->cur_sym }}{{ getAmount(auth()->user()->balance) }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="dashboard-item card border-0 h-100 p-md-4 mb-0 bs_1 p-3">
                        <div class="card-body p-0 d-flex justify-content-center align-items-center">
                            <div class="dashboard-thumb">
                                <i class="fas fa-wallet"></i>
                            </div>
                            <div class="dashboard-content">
                                <h5 class="title">@lang('Deposit')</h5>
                                <h4 class="amount">{{ $general->cur_sym }}{{ getAmount($deposit) }}</h4>
                            </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="dashboard-item card border-0 h-100 p-md-4 mb-0 bs_1 p-3">
                        <div class="card-body p-0 d-flex justify-content-center align-items-center">
                            <div class="dashboard-thumb">
                                <i class="far fa-credit-card"></i>
                            </div>
                            <div class="dashboard-content">
                                <h5 class="title">@lang('Withdraw')</h5>
                                <h4 class="amount">{{ $general->cur_sym }}{{ getAmount($withdraw) }}</h4>
                            </div>
                        </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="dashboard-item card border-0 h-100 p-md-4 mb-0 bs_1 p-3">
                        <div class="card-body p-0 d-flex justify-content-center align-items-center">
                            <div class="dashboard-thumb">
                               <i class="fas fa-money-check-alt"></i>
                            </div>
                            <div class="dashboard-content">
                                <h5 class="title">@lang('Total Transactions')</h5>
                                <h4 class="amount">{{ $transaction }}</h4>
                            </div>
                        </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="dashboard-item card border-0 h-100 p-md-4 mb-0 bs_1 p-3">
                        <div class="card-body p-0 d-flex justify-content-center align-items-center">
                            <div class="dashboard-thumb">
                               <i class="fas fa-money-bill"></i>
                            </div>
                            <div class="dashboard-content">
                                <h5 class="title">@lang('Total Commission')</h5>
                                <h4 class="amount">{{ $general->cur_sym }}{{ getAmount($commission) }}</h4>
                            </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="dashboard-item card border-0 h-100 p-md-4 mb-0 bs_1 p-3">
                        <div class="card-body p-0 d-flex justify-content-center align-items-center">
                            <div class="dashboard-thumb">
                                <i class="fas fa-coins"></i>
                            </div>
                            <div class="dashboard-content">
                                <h5 class="title">@lang('Total Invest')</h5>
                                <h4 class="amount">{{ $general->cur_sym }}{{ getAmount($order) }}</h4>
                            </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 mt-3">
                        <div class="item-rounded card border-0 h-100 bs_1 p-3  table-responsive-md">
                            <table class="deposite-table">
                                <thead class="custom--table ">
                                    <tr>
                                        <th>@lang('Date')</th>
                                        <th>@lang('TRX')</th>
                                        <th>@lang('Amount')</th>
                                        <th>@lang('Charge')</th>
                                        <th>@lang('Post Balance')</th>
                                        <th>@lang('Detail')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($transactions as $trx)
    <tr>
                                            <td data-label="@lang('Date')">
                                                {{ showDateTime($trx->created_at) }}
                                                <br>
                                                {{ diffforhumans($trx->created_at) }}
                                            </td>
                                            <td data-label="@lang('TRX')" class="font-weight-bold">{{ $trx->trx }}</td>
                                            <td data-label="@lang('Amount')" class="budget">
                                                <strong @if ($trx->trx_type == '+') class="text-success" @else class="text-danger" @endif> {{ $trx->trx_type == '+' ? '+' : '-' }} {{ getAmount($trx->amount) }} {{ __($general->cur_text) }}</strong>
                                            </td>
                                            <td data-label="@lang('Charge')" class="budget">{{ __(__($general->cur_sym)) }} {{ getAmount($trx->charge) }} </td>
                                            <td data-label="@lang('Post Balance')">{{ getAmount($trx->post_balance) }} {{ __($general->cur_text) }}</td>
                                            <td data-label="@lang('Detail')">{{ __($trx->details) }}</td>
                                        </tr>
                                @empty
                                        <tr>
                                            <td colspan="100%">{{ __($emptyMessage) }}</td>
                                        </tr>
    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div> -->
                <h4 class="font-weight-bold balck mt-2 tree_line d-none">Tree</h4>
                <div class="container d-none">
                    <ul id="org" style="display:none">
                        <li>
                            <label>{{ auth()->user()->username }}</label>
                            {!! $tree['tree_string'] !!}
                        </li>
                    </ul>

                    <div id="chart" class="orgChart" style="overflow-x: hidden;">
                        <!-- <div class="zoom">
                                <span class="zoom_control">+</span>

                                <div id="zoom_slider"></div>
                                <span class="zoom_control">-</span>
                            </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $encData = encrypt('saveHelpProof'); ?>;
    <input type="hidden" id="saveProof" value="{{ route('user.saveProof', $encData) }}">
    <!-- referral tree -->
    </section>
    <!-- referral tree -->
    @push('script')
        <script>
            function checkAmount() {
                var availAmount = parseFloat($('#availAmount').val());
                var getAmount = parseFloat($('#getAmount').val());

                if (isNaN(availAmount) || isNaN(getAmount)) {
                    notify('error', "Please enter valid numeric values.");
                    return false;
                }

                if (getAmount >= availAmount) {
                    notify('error', "Please enter an amount below your wallet balance.");
                    return false;
                }

                document.getElementById('saveOrderButton').type = 'submit';
                return true;
            }
            // $(document).on("keyup","#getAmount",function(){

            // });
            $(document).ready(function() {

                $(".nextBtn").prop("disabled", true);

                // Checkbox change event
                $("input[name='agree']").change(function() {
                    if ($(this).is(":checked")) {
                        // If the checkbox is checked, enable the "Next" button
                        $(".nextBtn").prop("disabled", false);
                    } else {
                        // If the checkbox is unchecked, disable the "Next" button
                        $(".nextBtn").prop("disabled", true);
                    }
                });

                // Step 1: Next button click event
                $(".nextBtn").click(function() {
                    var currentTab = $(this).closest(".tab-pane");
                    var nextTab = currentTab.next(".tab-pane");

                    // Add validation logic for the "warning" tab
                    if (currentTab.attr("id") === "warning") {
                        if (!$("input[name='agree']").is(":checked")) {
                            iziToast.warning({
                                message: "Please agree to the terms and conditions"
                            });
                            return false; // Prevent moving to the next tab
                        }
                    }

                    // Add validation logic for the "currency" tab
                    if (currentTab.attr("id") === "currency") {
                        var selectedCurrency = $("select[name='currency']").val();
                        if (selectedCurrency === "") {
                            alert("Please select a currency.");
                            return false;
                        }
                    }

                    currentTab.removeClass("show active");
                    nextTab.addClass("show active");
                });

                // Step 2: Previous button click event
                $(".prevBtn").click(function() {
                    var currentTab = $(this).closest(".tab-pane");
                    var prevTab = currentTab.prev(".tab-pane");

                    currentTab.removeClass("show active");
                    prevTab.addClass("show active");
                });


                $("#form").submit(function() {

                });
            });
            $(document).ready(function() {
                var currentTab = 0;

                $(".nextBtn").click(function() {
                    if (currentTab < 3) {
                        currentTab++;
                        $('#myTabContent .tab-pane').removeClass('active show');
                        $('#myTabContent .tab-pane').eq(currentTab).addClass('active show');
                    }
                });

                $(".prevBtn").click(function() {
                    if (currentTab > 0) {
                        currentTab--;
                        $('#myTabContent .tab-pane').removeClass('active show');
                        $('#myTabContent .tab-pane').eq(currentTab).addClass('active show');
                    }
                });
            });
        </script>
        <script>
            const proof = document.getElementById('proof');
            proof.addEventListener('change', () => {
                saveProve();
            });

            function saveProve() {
                const formData = new FormData();
                const imageFile = proof.files[0];
                const helpId = proof.getAttribute('data-id');
                if (imageFile) {
                    formData.append('image', imageFile);
                }
                const csrfToken = document.querySelector('input[name="_token"]').value;
                formData.append('_token', csrfToken);
                formData.append('help_id', helpId);
                const saveProofUrl = document.getElementById('saveProof');
                fetch(saveProofUrl.value, {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(response => {
                        const proofImg = document.getElementById('proofImg');
                        const img = response.data;
                        proofImg.querySelector('img').src = img;
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }
        </script>

        <script>
            function updateCountdown() {
                const currentTime = new Date().getTime();

                document.querySelectorAll('.countdown').forEach(countdownElement => {
                    const creationTime = parseInt(countdownElement.getAttribute('data-creation-time'));
                    const timeDifference = creationTime - currentTime;

                    if (timeDifference > 0) {
                        const remainingTime = 172800000 - timeDifference; // 48 hours in milliseconds
                        const hours = Math.floor(remainingTime / (1000 * 60 * 60));
                        const minutes = Math.floor((remainingTime % (1000 * 60 * 60)) / (1000 * 60));
                        const seconds = Math.floor((remainingTime % (1000 * 60)) / 1000);

                        countdownElement.textContent = `${hours}h ${minutes}m ${seconds}s`;
                    } else {
                        countdownElement.textContent = 'Expired';
                    }
                });

                setTimeout(updateCountdown, 1000); // Update every 1 second
            }

            updateCountdown();
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">

        <script>
            const deleteHelp = document.getElementById('delete-help');
            deleteHelp.addEventListener('click', () => {
                const deleteId = deleteHelp.getAttribute('data-id');
                const url = `cancel_help?id=${deleteId}`
                fetch(url)
                    .then(response => {
                        if (!response.ok) {
                            console.log("Network is not ok")
                        }
                    })
                    .then(data => {
                        toastr.success('Help cancelled successfully!', 'Success');
                        window.location.ṛeload();
                    })
                    .catch(error => {
                        console.log(error)
                    })
            });
        </script>

        <script>
            $(document).ready(function() {

                $("#org").jOrgChart({
                    chartElement: '#chart',
                    dragAndDrop: false,
                    slider: true
                });

                $('#chart .cgsnode').tooltip();

                $('#chart').kinetic();
            });
        </script>
        <script>
            "use strict";

            function myFunction() {
                var copyText = document.getElementById("referralURL");
                copyText.select();
                copyText.setSelectionRange(0, 99999);
                document.execCommand("copy");
                iziToast.success({
                    message: "Referral Url Copied: " + copyText.value,
                    position: "topRight"
                });
            }
        </script>
    @endpush
@endsection
