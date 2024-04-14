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
                                    <th>@lang('User|Admin')</th>
                                    @if(request()->routeIs('admin.pin.used'))
                                        <th>@lang('Username')</th>
                                    @endif
                                    <th>@lang('Amount')</th>
                                    <th>@lang('Pin')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Creations Date')</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($pins as $pin)
                                <tr>
                                    <td data-label="@lang('User|Admin')">
                                        @if($pin->generate_user_id != null)
                                            {{__($pin->details)}}
                                            <br>
                                            <span class="small text-center">
                                                <a href="{{ route('admin.users.detail', $pin->generate_user_id) }}"><span>@</span><span class="font-weight-bold">{{__($pin->createUser->username)}}</span></a>
                                            </span>
                                        @else
                                            {{__($pin->details)}}
                                            <br>
                                            <span class="small">
                                                <span class="font-weight-bold">@lang('admin')</span>
                                            </span>
                                        @endif
                                    </td>
                                    @if(request()->routeIs('admin.pin.used'))
                                        <td data-label="@lang('User')">
                                            <span class="font-weight-bold">{{__($pin->user->fullname)}}</span>
                                            <br>
                                            <span class="small">
                                            <a href="{{ route('admin.users.detail', $pin->user_id) }}"><span>@</span>{{__($pin->user->username)}}</a>
                                            </span>
                                        </td>
                                    @endif
                                    <td data-label="@lang('Amount')">
                                        <span class="font-weight-bold">{{getAmount($pin->amount)}} {{__($general->cur_text)}}</span>
                                    </td>
                                    <td data-label="@lang('Pin')">
                                        {{__($pin->pin)}}
                                    </td>
                                    <td data-label="@lang('Status')">
                                        @if($pin->status == 1)
                                            <span class="badge badge--success">@lang('Used')</span>
                                            <br>
                                            {{ diffForHumans($pin->updated_at) }}
                                        @elseif($pin->status == 0)
                                            <span class="badge badge--danger">@lang('Unused')</span>
                                        @endif
                                    </td>
                                    <td data-label="@lang('Creations Date')"> 
                                        {{ showDateTime($pin->created_at) }} <br> {{ diffForHumans($pin->created_at) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{__($emptyMessage) }}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer py-4">
                    {{paginateLinks($pins)}}
                </div>
            </div>
        </div>
    </div>


    <div id="addModalPin" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Created Pin')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.pin.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        
                        <div class="form-group">
                            <label for="amount" class="form-control-label font-weight-bold">@lang('Amount')</label>
                            <div class="input-group mb-3">
                                <input type="text" id="amount" class="form-control form-control-lg" placeholder="@lang('Enter Amount')" name="amount" aria-label="Recipient's username" aria-describedby="basic-addon2" required="">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">{{$general->cur_text}}</span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="number" class="form-control-label font-weight-bold">@lang('Total Number Of Created Pin')</label>
                            <input type="text" class="form-control form-control-lg" name="number" placeholder="@lang("Enter Number")" required="">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--primary">@lang('Created')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <a href="javascript:void(0)" class="btn btn--primary btn-lg box--shadow1 text--small addPin" ><i class="fa fa-fw fa-paper-plane"></i>@lang('Created Pin')</a>
    <form action="{{route('admin.pin.search')}}" method="GET" class="form-inline float-sm-right bg--white mb-2 ml-0 ml-xl-2 ml-lg-0">
        <div class="input-group has_append  ">
            <input type="text" name="search" class="form-control" placeholder="@lang('Pin Number')" value="{{ $search ?? '' }}">
            <div class="input-group-append">
                <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form>
@endpush

@push('script')
    <script>
        (function($){
            "use strict";
            $('.addPin').on('click', function() {
                $('#addModalPin').modal('show');
            });
        })(jQuery);
    </script>
@endpush
