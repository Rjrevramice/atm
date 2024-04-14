@extends('admin.layouts.app')
@section('panel')
    <div class="row mb-none-30">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                   <form action="{{ route('admin.product.update',$products->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                    <div class="row">
                            <div class="form-group col-lg-6">
                                <label for="name" class="form-control-label font-weight-bold">@lang('Name')<sup class="text--danger">*</sup></label>
                                <input type="text" class="form-control form-control-lg" name="name" value="{{__($products->name) }}"  maxlength="100" required="">
                            </div>
                             <div class="form-group col-lg-6">
                                <label for="Dimension" class="form-control-label font-weight-bold">@lang('Dimension') </label>
                                <input type="text" class="form-control form-control-lg" name="dimension" value="{{__($products->dimension) }}">
                            </div>

                             <div class="form-group col-lg-6">
                                <label for="short_description" class="form-control-label font-weight-bold">@lang('Short Description') 
                                </label>
                               <textarea class="form-control form-control-lg" name="short_description" style="height:50px" >{{$products->short_description}}</textarea>
                            </div>
                                                        
                          <div class="form-group col-lg-6">
                                <label for="material_type" class="form-control-label font-weight-bold">@lang('Long Description') 
                                </label>
                                <textarea class="form-control form-control-lg" name="long_description" style="height:50px">{{$products->long_description}}</textarea>
                            </div>

                              <div class="form-group col-lg-6">
                                <label for="material_type" class="form-control-label font-weight-bold">@lang('Material type') 
                                </label>
                                <input type="text" class="form-control form-control-lg" name="material_type" value="{{__($products->material_type) }}">
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="name" class="form-control-label font-weight-bold">@lang('Select Category Name')</label>
                            <select class="form-control select2 form-control-lg" style="font-size:1rem; padding:10px 20px;"" required name="category_id" data-placeholder="Choose Category">
                               @foreach ($categories as $cat)
                              <option value="{{ $cat->id }}" @if($cat->id == $products->category_id) selected @endif >{{$cat->name}}</option>
                            @endforeach
                            </select>
                         </div>
                            <div class="form-group col-lg-6">
                                <label for="Price" class="form-control-label font-weight-bold">@lang('Price')<sup class="text--danger">*</sup> </label>
                                <input type="text" class="form-control form-control-lg" name="price" value="{{__($products->price) }}">
                            </div>

                            <div class="form-group col-lg-6">
                                <label for="Size" class="form-control-label font-weight-bold">@lang('Size')<sup class="text--danger">*</sup> </label>
                                <input type="text" class="form-control form-control-lg" name="size" value="{{__($products->size) }}">
                            </div>

                            <!-- <div class="form-group col-lg-6">
                                <label for="price" class="form-control-label font-weight-bold">@lang('Price') 
                                </label>
                                <input type="text" class="form-control form-control-lg" name="price" value="{{__($products->price) }}">
                            </div> -->
                            <div class="form-group col-lg-6">
                                <label class="form-control-label font-weight-bold">@lang('Image') <sup class="text--danger">*</sup></label>
                                <div class="">
                                <input type="file" class="form-control-lg"  name="image" id="image" value="<img src="{{ getImage('assets/images/frontend/product/'. $products->image, '350x260')}}" alt="product">
                                </div>
                            </div>

                           


                            <div class="form-group col-lg-6">
                                <label class="form-control-label font-weight-bold">@lang('Status') </label>
                                <input type="checkbox" class="form-control-lg" data-width="100%" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" data-on="@lang('Enable')" data-off="@lang('Disabled')" @if($products->status) checked @endif name="status">
                            </div>
                        
                          </div>
                          <div class="form-group">
                            <button type="submit" class="btn btn--primary btn-block"><i class="fa fa-fw fa-paper-plane"></i>@lang('Update')</button>
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
