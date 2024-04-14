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
                                    <th>@lang('SI.No')</th>
                                    <th>@lang('Product Name')</th>
                                    <th>@lang('Image')</th>
                                    <th>@lang('Price')</th>
                                    <th>@lang('Qty')</th>
                                    <th>@lang('SubTotal')</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($items as $item)
                                <tr>
                                    <td>{{  $loop->iteration }}</td>
                                    <td data-label="@lang('Name')">
                                      {{__ ($item->name) }}
                                     </td>
                                     <td data-label="@lang('Image')">
                                     <img src="{{ getImage('assets/images/frontend/product/'. $item->image, '350x260')}}" class="cate-img w-100" alt="product">
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
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{__($emptyMessage) }}</td>
                                </tr>
                            @endforelse
                            <tr>
                              <td class="font-weight-bold" style="font-size:18px; color:black" colspan="5">@lang('Total')</td>
                              <td class="font-weight-bold" style="font-size:18px; color:black">{{__ ($item->total) }}
                             </td>
                            </tr>
                            </tbody>
                        </table>
                     </div>
                </div>
             </div>
        
        </div>
    </div>

@endsection



