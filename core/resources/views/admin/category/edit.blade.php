@extends('admin.layouts.app')
@section('panel')
    <div class="row mb-none-30">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                   <form action="{{ route('admin.category.update',$category->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                      <div class="row aling-items-center">
                            <div class="form-group col-md-6">
                                <label for="name" class="form-control-label font-weight-bold">@lang('Name')<sup class="text--danger">*</sup></label>
                                <input type="text" class="form-control form-control-lg" name="name" value="{{__($category->name)}}"  maxlength="100" required="">
                            </div>

                           <div class="form-group col-md-6">
                            <label for="image" class="form-control-label font-weight-bold">@lang('Image')<sup class="text--danger">*</sup></label>
                              <div class=""><input type="file" name="image" value="{{ $category->image }}"/>
                            </div>
                            </div>
                      </div>
                        <div class="row  justify-content-end">                   
                            <div class="form-group col-lg-3 col-md-4 mb-0">
                                <button type="submit" class="btn btn--primary btn-block w-100"><i class="fa fa-fw fa-paper-plane"></i>@lang('Update')</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <a href="{{route('admin.category.index')}}" class="btn btn-sm btn--primary box--shadow1 text--small" ><i class="las la-angle-double-left"></i>@lang('Go Back')</a>
@endpush
