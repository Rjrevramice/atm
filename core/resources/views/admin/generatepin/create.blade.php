@extends('admin.layouts.app')
@section('panel')

 <div class="row mb-none-30">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                   <form action="{{ route('admin.generatepin.store') }}" method="POST">
                        @csrf
                        <div class="row align-items-center">
                            <div class="form-group col-md-6">
                                <label for="name" class="form-control-label font-weight-bold">@lang('Set PIN') <sup class="text--danger">*</sup></label>
                                <input type="text" readonly id="pin" class="form-control form-control-lg" name="value" value="{{old('value')}}">
                          </div>
                          <div class="form-group col-md-6">
                                <label for="name" class="form-control-label font-weight-bold">@lang('Amount') <sup class="text--danger">*</sup></label>
                                <input type="number"  id="amount" class="form-control form-control-lg" name="amount" value="{{old('amount')}}" required>
                          </div>
                            <div class="form-group col-md-6">
                             <!--    <label class="form-control-label font-weight-bold">@lang('Status') </label>
                               <input type="checkbox" class="form-control-lg" data-width="100%" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" data-on="@lang('Enable')" data-off="@lang('Disabled')" name="status">-->
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12 d-flex justify-content-end align-items-center">
                                <div class="form-group mb-0 mr-3">
                                    <button type="button" id="random" class="btn btn-info generate_btn w-100" ><i class="fas fa-plus mr-2"></i>@lang('Generate')</button>
                                </div>
                                <div class="form-group mb-0">
                                  <button type="submit" class="btn btn--success  btn-block w-100"><i class="fas fa-save mr-2"></i>@lang('Add')</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
   </div>
@endsection


@push('breadcrumb-plugins')
    <a href="{{route('admin.generatepin.index')}}" class="btn btn-sm btn--primary box--shadow1 text--small" ><i class="las la-angle-double-left"></i>@lang('Go Back')</a>
@endpush

@push('script')
   <script>
        'use strict';
        $(document).on('click','.generate_btn' , function(){

      
            $.ajax({
                headers: {"X-CSRF-TOKEN": "{{ csrf_token() }}",},
                url:"{{ route('admin.getpin') }}",
                method:"POST",
                success:function(data)
                {
                   $('#pin').val(JSON.parse(data));
                }
            });
              });
</script>
@endpush
