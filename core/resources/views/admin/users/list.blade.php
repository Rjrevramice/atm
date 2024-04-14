@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two" id="myTable">
                            <thead>
                            <tr>
                                <th>@lang('User')</th>
                                <th>@lang('Email')</th>
                                <th>@lang('Phone')</th>
                                <th>@lang('City')</th>
                                <th>@lang('zip')</th>
                                <th>@lang('Address')</th>
                                <th>@lang('Account Holder Name')</th>
                                <th>@lang('Account No')</th>
                                <th>@lang('Branch')</th>
                                <th>@lang('IFSC')</th>
                                <th>@lang('Balance')</th>
                                <th>@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($users as $user)
                            <tr>
                                <td data-label="@lang('User')">
                                    <span class="font-weight-bold">{{$user->fullname}}</span>
                                    <br>
                                    <span class="small">
                                    <a href="{{ route('admin.users.detail', $user->id) }}"><span>@</span>{{ $user->username }}</a>
                                    </span>
                                </td>


                                <td data-label="@lang('Email')">
                                    {{ $user->email }}
                                </td>
                                <td data-label="@lang('Phone')">
                                    {{ $user->mobile }}
                                </td>
                                
                                <td data-label="@lang('City')">
                                    {{ $user->address->city }}
                                </td>
                               
                                <td data-label="@lang('Zip')">
                                    {{ $user->address->zip }}
                                </td>
                                <td data-label="@lang('Address')">
                                    {{ $user->address->address }}
                                </td>



                                <td data-label="@lang('Account Holder Name')">
                                    {{ $user->address->acc_name }} 
                                </td>
                                <td data-label="@lang('Account Number')">
                                    {{ $user->address->acc_no }} 
                                </td>
                                <td data-label="@lang('Branch')">
                                    {{ $user->address->br_name }} 
                                </td>
                                <td data-label="@lang('IFSC')">
                                    {{ $user->address->ifsc }} 
                                </td>


                                <td data-label="@lang('Balance')">
                                    <span class="font-weight-bold">
                                        
                                    {{ $general->cur_sym }}{{ showAmount($user->balance) }}
                                    </span>
                                </td>



                                <td data-label="@lang('Action')">
                                    <a href="{{ route('admin.users.detail', $user->id) }}" class="icon-btn" data-toggle="tooltip" title="" data-original-title="@lang('Details')">
                                        <i class="las la-desktop text--shadow"></i>
                                    </a>
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
                    {{ paginateLinks($users) }}
                </div>
            </div>
        </div>


    </div>
@endsection
@push('script')
<script>

$(document).ready(function() {
    $('#myTable').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'csv', 'excel', 'print'
        ]
    } );
} );
</script>
@endpush


@push('breadcrumb-plugins')
    <form action="{{ route('admin.users.search', $scope ?? str_replace('admin.users.', '', request()->route()->getName())) }}" method="GET" class="form-inline float-sm-right bg--white">
        <div class="input-group has_append">
            <input type="text" name="search" class="form-control" placeholder="@lang('Username or email')" value="{{ $search ?? '' }}">
            <div class="input-group-append">
                <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form>
@endpush
