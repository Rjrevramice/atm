@extends($activeTemplate.'layouts.master')
@section('content')
@include($activeTemplate.'partials.breadcrumb')


<style>
    .custom--table{
        background-color: #4e4eff !important;
    }
</style>


<div class="transaction-section my-5 cart-table table-responsive">
     <div class="container">
            <div class=" mb-2 item-rounded">
               @if(!empty($trx))
                <?php 
                    $principleAmount = $trx->amount; 
                    $returnPercentage = $trx->return_percentage; 
                    $numberOfDays = 100; 

                    $currentDate = strtotime(date('Y-m-d',strtotime($trx->created_at))); 
                    $newData = [];
                    $total = 0;     
                    for ($i = 0; $i < $numberOfDays; $i++) {
                        $nextDate = date('Y-m-d', strtotime("+$i days", $currentDate));

                        
                        $trx = (object)[
                            'created_at' => $nextDate,
                            'current_token' => $trx->current_token,
                            'trx_type' => '+',
                            'amount' => $principleAmount,
                           
                        ];

                        $provideGrowth = (($returnPercentage / 100) * $principleAmount) / 30;
                        $total += ($i === 0) ? ($principleAmount + $provideGrowth) : $provideGrowth;
                        
                        $row = [
                            'created_at' => $nextDate,
                            'current_token' => $trx->current_token,
                            'amount' => getAmount($trx->amount) ,
                            'provide_growth' => getAmount($provideGrowth) . __($general->cur_text),
                            'trx_type'=> '+' ,
                            'total' => getAmount($total) . __($general->cur_text)
                        ];

                        $newData[] = $row;
                        
                    }
                    ?>
<table class="deposite-table table">
    <thead class="custom--table">
        <tr>
            <th rowspan="2">@lang('Date of created')</th>
            <th rowspan="2">@lang('Ticket Id')</th>
            <th rowspan="2">@lang('Principle Amount')</th>
            <th colspan="2">@lang('Growth')</th>
        </tr>
        <tr>
            <th>@lang('Daily Growth')</th>
            <th>@lang('Total Growth')</th>
        </tr>
    </thead>
    <tbody>
        <div>
            @forelse($newData as $index => $trx)
            <tr>
                @if($index === 0) <!-- Show these columns only for the first row -->
                    <td data-label="@lang('Date')">
                        {{ date('Y-m-d',strtotime($trx['created_at'])) }}
                        <br>
                    </td>
                    <td data-label="@lang('TRX')" class="font-weight-bold">
                        {{ $trx['current_token'] }}
                    </td>
                    <td data-label="@lang('Amount')">
                        <strong > {{getAmount($trx['amount'])}} {{__($general->cur_text)}}</strong>
                    </td>
                @else
                    <td colspan="3"></td> 
                @endif

                <td data-label="@lang('Charge')">
                    <strong class="text-success"> +{{ $trx['provide_growth'] }}</strong>
                </td>

                <td data-label="@lang('Charge')">
                    <strong class="text-success"> +{{ $trx['total'] }}</strong>
                    @if($index % 30 == 0 && $index != 0)
                        <span class="badge badge-info">Withdraw</span>
                    @endif
                </td>
                
               
            </tr>
        @empty
            <tr>
                <td colspan="100%">{{ __($emptyMessage) }}</td>
            </tr>
        @endforelse 
        </div>
    </tbody>
</table>

                <!-- <table class="deposite-table">
                    <thead class="custom--table">
                        <tr>
                            <th>@lang('Date of created')</th>
                            <th>@lang('Ticket Id')</th>
                            <th>@lang('Principle Amount')</th>
                            <th>@lang('Daily Growth')</th>
                            <th>@lang('Total Growth')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($newData as $trx) 
                            <tr>
                                <td data-label="@lang('Date')">
                                    {{ date('Y-m-d',strtotime($trx['created_at'])) }}
                                    <br>
                                </td>

                                <td data-label="@lang('TRX')" class="font-weight-bold">
                                    {{ $trx['current_token'] }}
                                </td>

                                <td data-label="@lang('Amount')">
                                    <strong > {{getAmount($trx['amount'])}} {{__($general->cur_text)}}</strong>
                                </td>

                                <td data-label="@lang('Charge')">
                                  <strong class="text-success"> +{{ $trx['provide_growth'] }}</strong>
                                </td>

                                <td data-label="@lang('Charge')">
                                  <strong class="text-success"> +{{ $trx['total'] }}</strong>
                                </td>

                                
                            </tr>
                       @empty
                            <tr>
                                <td colspan="100%">{{ __($emptyMessage) }}</td>
                            </tr>
                        @endforelse 
                    </tbody>
                </table> -->
                @else
                    <h4 class="text-center">You didn't provide any help yet.</h4>
                @endif
           <?php /* {{$transactions->links()}} */?>
            </div>
        </div>
    </div>
@endsection



