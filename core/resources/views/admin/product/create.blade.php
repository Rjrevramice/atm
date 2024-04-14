@extends('admin.layouts.app')
@section('panel')
    <div class="row mb-none-30">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                   <form action="{{ route('admin.product.store') }}" method="POST"  enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                             <div class="form-group col-lg-6">
                                <label for="name" class="form-control-label font-weight-bold">@lang('Name') <sup class="text--danger">*</sup></label>
                                <input type="text" class="form-control form-control-lg" name="name" value="{{old('name')}}"  maxlength="100" placeholder="@lang('Enter Name')" required="">
                            </div>

                             <div class="form-group col-lg-6">
                                <label for="Dimension" class="form-control-label font-weight-bold">@lang('Dimension') </label>
                                <input type="text" class="form-control form-control-lg" name="dimension" value="{{old('long_description')}}"  maxlength="100" placeholder="@lang('Enter dimension')" >
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="material_type" class="form-control-label font-weight-bold">@lang('Material type') 
                                </label>
                                <input type="text" class="form-control form-control-lg" name="material_type" value="{{old('material_type')}}"  maxlength="100" placeholder="@lang('Enter Material type')">
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="name" class="form-control-label font-weight-bold">@lang('Select Category Name')</label>
                              <select name="category_id" class="form-control form-control-lg" style="font-size:1rem; padding:10px 20px;">
                                 @foreach($category as $id => $name)
                              <option value="{{ $name->id }}">{{ $name->name }}</option>
                                @endforeach
                            </select>
                         </div>

                             <div class="form-group col-lg-6">
                                <label for="short_description" class="form-control-label font-weight-bold">@lang('Short Description') 
                                </label>
                               <textarea class="form-control form-control-lg" name="short_description" style="height:50px" placeholder="@lang('Enter Short Description')"></textarea>
                            </div>
                                                        
                          <div class="form-group col-lg-6">
                                <label for="material_type" class="form-control-label font-weight-bold">@lang('Long Description') 
                                </label>
                                <textarea class="form-control form-control-lg" name="long_description" style="height:50px" placeholder="@lang('Enter Long Description')"></textarea>
                            </div>
                            <div class="form-group col-lg-6">
                                <label class="form-control-label font-weight-bold">@lang('Price')<sup class="text--danger">*</sup></label>
                                <div class=""><input type="text" class="form-control form-control-lg w-100"  name="price" id="price" placeholder="Enter Amount"></div>
                                
                            </div>

                            <div class="form-group col-lg-6">
                                <label class="form-control-label font-weight-bold">@lang('Size')<sup class="text--danger">*</sup></label>
                                <div class=""><input type="text" class="form-control form-control-lg w-100"  name="size" id="size" placeholder="Enter Size"></div>
                                
                            </div>
                         
                            <div class="form-group col-lg-6">
                                <label class="form-control-label font-weight-bold">@lang('Image')<sup class="text--danger">*</sup> </label>
                                <div class="">
                                <input type="file" class="form-control-lg"  name="image" id="image" placeholder="Choose Image">
                                </div>
                                
                            </div>

                             <div class="form-group col-lg-6">
                                <label class="form-control-label font-weight-bold">@lang('Status') </label>
                                <input type="checkbox" class="form-control-lg" data-width="100%" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" data-on="@lang('Enable')" data-off="@lang('Disabled')" name="status">
                            </div>

                          </div>
  
                        <div class="form-group">
                            <button type="submit" class="btn btn--primary btn-md btn-block"><i class="fa fa-fw fa-paper-plane"></i>@lang('Create')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <a href="{{route('admin.product.index')}}" class="btn btn-sm btn--primary box--shadow1 text--small" ><i class="las la-angle-double-left"></i>@lang('Go Back')</a>
@endpush


