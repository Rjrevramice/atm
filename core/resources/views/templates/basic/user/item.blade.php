@extends($activeTemplate.'layouts.frontend')
@section('content')


<div class="container my-5 table-responsive cart-table" style="height:50vh">
    <div class="row">
        <div class="col-12">
        <h5 class="text-left mb-3 font-weight-bold">{{$pageTitle}}</h5>
            <table id="cart" class="table table-bordered ">
                <thead class="thead-light">
                    <tr>
                         <tr>
                                    <th>@lang('SI.No')</th>
                                    <th>@lang('Product')</th>
                                    <th>@lang('Image')</th>
                                    <th>@lang('Price')</th>
                                    <th>@lang('Quantity')</th>
                                    <th>@lang('SubTotal')</th>
                                 </tr>
                          </tr>
                </thead>
                <tbody>
                    <?php $total = 0;?>
                    <?php if(count($itemlist) > 0){?>
                   
                    @foreach($itemlist as $item)
                   
                        <div class="row">
                             <tr>
                                    <td>{{  $loop->iteration }}</td>
                                    <td data-label="@lang('Name')">
                                      {{__ ($item->name) }}
                                     </td>
                                    <td data-label="@lang('Image')">
                                     <img src="{{ getImage('assets/images/frontend/product/'. $item->image, '350x260')}}" class="cate-img w-100 object-contain"  alt="item">
                                     </td>
                                  <td data-label="@lang('Price')">
                                         {{__ ($item->price) }}
                                     </td>
                                    <td data-label="@lang('Qty')">
                                    {{__ ($item->quantity) }}
                                     </td>
                          <td data-label="@lang('SubTotal')">
                                    {{__ ($item->price)*($item->quantity) }}
                                     </td>
                                 </tr>
                        </div>
                        @endforeach
                        <tr>
                            <td colspan="5">
                                <h5>
                                @lang('Total')
                                </h5>
                            </td>
                            <td colspan="">
                                <h5>
                                {{__ ($item->total) }}
                                </h5>
                            </td>
                        </tr>
                </tbody>
             <!--   <tfoot>
                    <tr>
                        <td colspan="4"><h6 class="table-row-header">Total</h6></td>
                        <td colspan=""><h6 class="table-row-header text-center"><input type="hidden" name="overall_total" id="overall_total" value="{{ $total }}"><input type="hidden" name="checkout_user_id" id="checkout_user_id" value="{{ auth()->user()->id }}"> {{ $total }}</h6></td>
                    </tr>
                </tfoot>-->
                <?php }else{ ?>
                        <tr>
                            <td colspan="6" class="text-center font-weight-bold">No Item In Cart</td>
                        <tr>
                <?php    }?>    
            </table>
        </div>
    </div>
         <!-- <div>
         <h4 class="text-right">@lang('Total')
            {{__ ($item->total) }}</h4>
        </div> -->
</div>
@endsection
