@extends($activeTemplate.'layouts.master')
@section('content')
@include($activeTemplate.'partials.breadcrumb')
<div class="transaction-section my-5 table-responsive card-table">
     <div class="container">
            <div class="mb-2 item-rounded ">
                <table class="deposite-table table table-bordered">
                    <thead class="thead-light ">
                        <tr>
                            <th>@lang('User')</th>
                            <th>@lang('TRX')</th>
                            <th>@lang('Amount')</th>
                            <th>@lang('Post Balance')</th>
                            <th>@lang('Date')</th>
                            <th>@lang('Detail')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($commissions as $commission)
                            <tr>
                                 <td data-label="@lang('User')">{{$commission->fromUser->username}}</td>
                                <td data-label="@lang('TRX')" class="font-weight-bold">{{$commission->trx}}</td>
                                <td data-label="@lang('Amount')" class="budget">
                                    <strong class="text-success">+ {{getAmount($commission->amount)}} {{__($general->cur_text)}}</strong>
                                </td>
                                <td data-label="@lang('Post Balance')">{{ getAmount($commission->post_balance) }} {{__($general->cur_text)}}</td>
                                <td data-label="@lang('Date')">
                                    {{ showDateTime($commission->created_at) }}
                                    <br>
                                    {{ diffForHumans($commission->created_at) }}
                                </td>
                                <td data-label="@lang('Detail')">{{ __($commission->details) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="100%">{{ __($emptyMessage) }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                    {{$commissions->links()}}
            </div>
        </div>
    </div>
@endsection



