@extends('admin.layouts.app')

@section('panel')
<div class="row">

    <div class="col-lg-12">
        <div class="card b-radius--10 ">
            <div class="card-body p-0">
                <div class="table-responsive--sm table-responsive">
                    <table class="table table--light style--two">
                        <thead>
                            <tr>
                                <th>@lang('User')</th>
                                <th>@lang('Mobile')</th>
                                <th>@lang('Date of created ')</th>
                                <th>@lang('Amount')</th>
                                <th>@lang('Growth Percentage')</th>
                               
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($helps as $trx)
                            <tr>
                                <td data-label="@lang('User')">
                                    <span class="font-weight-bold">{{ $trx->user->firstname }}</span>
                                    <br>
                                    <span class="small"> <a href="{{ route('admin.users.detail', $trx->user_id) }}"><span></span>{{$trx->user->email}}</a> </span>
                                </td>

                                <td data-label="@lang('Trx')">
                                    <strong>{{ $trx->user->mobile }}</strong>
                                </td>

                                <td data-label="@lang('Transacted')">
                                    {{ showDateTime($trx->created_at) }}<br>{{ diffForHumans($trx->created_at) }}
                                </td>

                                <td data-label="@lang('Amount')" class="budget">
                                    <span class="font-weight-bold @if($trx->trx_type == '+')text-success @else text-danger @endif">
                                        {{ $trx->trx_type }} {{showAmount($trx->amount)}} {{ $general->cur_text }}
                                    </span>
                                </td>

                                <td data-label="@lang('Post Balance')" class="budget">
                                   {{ $trx->return_percentage }}
                               </td>
                           </tr>
                           @empty
                           <tr>
                            <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                        </tr>
                        @endforelse

                    </tbody>
                </table><!-- table end -->
            </div>
        </div>
        <div class="card-footer py-4">
            {{ paginateLinks($helps) }}
        </div>
    </div><!-- card end -->
</div>
</div>
<script>
    document.addEventListener("DOMContentLoaded",()=>{
        const search = document.querySelectorAll(".has_append");
        search.forEach(searchResult =>{
            searchResult.style.display = "none";
        });
    });
</script>

@endsection


@push('breadcrumb-plugins')
@if(request()->routeIs('admin.users.transactions'))
<form action="" method="GET" class="form-inline float-sm-right bg--white">
    <div class="input-group has_append">
        <input type="text" name="search" class="form-control" placeholder="@lang('TRX / Username')" value="{{ $search ?? '' }}">
        <div class="input-group-append">
            <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
        </div>
    </div>
</form>
@else
<form action="{{ route('admin.report.transaction.search') }}" method="GET" class="form-inline float-sm-right bg--white">
    <div class="input-group has_append">
        <input type="text" name="search" class="form-control" placeholder="@lang('TRX / Username')" value="{{ $search ?? '' }}">
        <div class="input-group-append">
            <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
        </div>
    </div>
</form>
@endif
@endpush


