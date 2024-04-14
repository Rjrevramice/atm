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
                                    <th>@lang('#Order Id')</th>
                                    <th>@lang('Customer Name')</th>
                                    <th>@lang('Email')</th>
                                    <th>@lang('Mobile')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>

                            @forelse($order as $ord)
                                <tr>
                                    <td>{{  $loop->iteration }}</td>
                                    <td data-label="@lang('Id')">
                                      {{'#'}}  {{__($ord->id)}}
                                    </td>

                                    <td data-label="@lang('Name')">
                                      {{__ ($ord->username) }}
                                     </td>
                                     <td data-label="@lang('Email')">
                                         {{__ ($ord->email) }}
                                     </td>
                                    <td data-label="@lang('Mobile')">
                                    {{__ ($ord->mobile) }}
                                     </td>
                                    <td> 
                             <input type="hidden" id="oid"  name="oid">
                             <select class="form-control m-input status" id="status" name="status" order_id="{{$ord->id}}">
                           <option value="0" {{ $ord->status == 0 ? 'selected' : 'Pending' }}>Pending</option>
                            <option value="1" {{ $ord->status == 1 ? 'selected' : 'Shipped' }}>Shipped</option>
                            <option value="2" {{ $ord->status == 2 ? 'selected' : 'Delivered' }}>Delivered</option>
                            </select>  
                              </td>
                                   <td data-label="@lang('Action')">
                                      <a href="{{route('admin.order.list', $ord->id)}}" class="icon-btn btn--primary mr-2"> <i class="la la-eye"></i>
                                        </a>
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
            </div>
           <div class="card-footer py-4">
                    {{ paginateLinks($order) }}
                </div>
        </div>
    </div>

@endsection

@push('script')
<script type="text/javascript">
 $( ".status" ).change(function() { 
        var oid =  $(this).attr('order_id');
        var status = $(this).val();
         $.ajax({
            headers: {"X-CSRF-TOKEN": "{{ csrf_token() }}",},
            method: "POST",
            url: "{{ route('admin.update') }}",
            data:{id:oid,status:status},
            success:function(data, textStatus, statusCode){
              if(statusCode.status == 200){
                 notify('success', data.message);
                     }
                    }
              });
          
     });
</script>
@endpush

