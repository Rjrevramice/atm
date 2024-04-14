@extends($activeTemplate.'layouts.master')
@section('content')
@include($activeTemplate.'partials.breadcrumb')
<div class="transaction-section my-5 cart-table table-responsive">
     <div class="container">
            <div class=" mb-2 item-rounded">
                <h1 class="text-center">Under Construction</h1>
                <?php /*<table class="deposite-table">
                    <thead class="custom--table">
                        <tr>
                            <th>@lang('Date of created')</th>
                            <th>@lang('Ticket Id')</th>
                            <th>@lang('Principle Amount')</th>
                            <th>@lang('Provide Growth')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($growth as $trx)
                       
                            <tr>
                                <td data-label="@lang('Date')">
                                    {{ showDateTime($trx->created_at) }}
                                    <br>
                                    <!-- {{diffforhumans($trx->created_at)}} -->
                                </td>
                                <td>{{$trx->current_token}}</td>
                                <td data-label="@lang('Amount')">
                                    <strong >    {{getAmount($trx->amount)}} {{__($trx->currency)}}</strong>
                                </td>

                                <td data-label="@lang('Charge')">
                                    {{$trx->return_percentage}} % 
                                </td>
                               
                            </tr>
                        @empty
                            <tr>
                                <td colspan="100%">{{ __($emptyMessage) }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table> */?>
           <?php /* {{$growth->links()}} */?>
            </div>
        </div>
    </div>
@endsection



