@extends($activeTemplate.'layouts.frontend')
@section('content')

<div class="container my-5 table-responsive cart-table" style="height:50vh">
    <h5 class="text-left mb-3 font-weight-bold">{{$pageTitle}}</h5>
    <div class="row">
        <div class="col-12">
            <table id="cart" class="table table-bordered ">
                <thead class="thead-light">
                    <tr>
                        <tr>
                            <th>@lang('SI.No')</th>
                            <th>@lang('#Order Id')</th>
                            <th>@lang('Customer Name')</th>
                            <th>@lang('Mobile')</th>
                            <th>@lang('Email')</th>
                            <th>@lang('Status')</th>
                            <th>@lang('Action')</th>
                        </tr>
                    </tr>
                </thead>
                <tbody>
                    <?php $total = 0;?>
                    <?php if(count($items) > 0){?>
                   
                    @foreach($items as $details)
                  
                        <div class="row">
                            <tr>
                         <td>{{  $loop->iteration }}</td>
                        <td data-label="@lang('Id')">
                         {{'#'}}  {{__($details->id)}}
                       </td>
                            <td data-th="Name">{{ $details->username }}</td>
                            <td data-th="Mobile">{{ $details->mobile }}</td>
                            <td data-th="Email">{{ $details->email }}</td>
                            <td data-th="Status">
                                 @if($details->status == 0)
                                     Pending 
                                    @elseif($details->status==1)
                                        Shipped 
                                     @else
                                    Delivered
                                @endif</td>
                               <td data-label="@lang('Action')">
                                     <a href="{{route('user.item', $details->id)}}" class="icon-btn btn-theme text-white order-action"> <i class="la la-eye"></i>
                                        </a>
                            </tr>
                        </div>
                        @endforeach
                </tbody>
             <!--   <tfoot>
                    <tr>
                        <td colspan="4"><h6 class="table-row-header">Total</h6></td>
                        <td colspan=""><h6 class="table-row-header text-center"><input type="hidden" name="overall_total" id="overall_total" value="{{ $total }}"><input type="hidden" name="checkout_user_id" id="checkout_user_id" value="{{ auth()->user()->id }}"> {{ $total }}</h6></td>
                    </tr>
                </tfoot>-->
                <?php }else{ ?>
                        <tr>
                            <td colspan="7" class="text-center font-weight-bold">No Orders</td>
                        <tr>
                <?php    }?>    
            </table>
        </div>
        <div class="col-12">
        <div class="card-footer border-0 transparent_bg">
            {{ paginateLinks($items) }}
        </div>
        </div>
    </div>
</div>
@endsection
