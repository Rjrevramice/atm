@extends('admin.layouts.app')
@section('panel')
    <div class="row mb-none-30">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                   <form action="{{ route('admin.get_help.update',$getHelp->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                      <div class="row aling-items-center">
                            <div class="form-group col-md-6">
                                <label for="name" class="form-control-label font-weight-bold">@lang('User Name')</label>
                                <input type="text" readonly class="form-control form-control-lg" name="name" value="{{__($getHelp->user->firstname)}}"  maxlength="100" required="">
                            </div>

                           <div class="form-group col-md-6">
                                <label for="image" class="form-control-label font-weight-bold">@lang('Currency')<sup class="text--danger">*</sup></label>
                                <div class="">
                                    <select name="currency" id="" class="form-control">
                                        <option value="INR" <?php if($getHelp->currency == "INR"){echo "selected";}?>>INR</option>
                                        <option value="USD" <?php if($getHelp->currency == "USD"){echo "selected";}?>>USD</option>
                                    </select>
                                    
                                </div>
                            </div>
                           <div class="form-group col-md-6">
                                <label for="image" class="form-control-label font-weight-bold">@lang('Amount')<sup class="text--danger">*</sup></label>
                                <div class="">
                                    <input type="number" class="form-control" name="amount" value="{{ number_format($getHelp->amount,2) }}"/>
                                </div>
                            </div>
                           <div class="form-group col-md-6">
                                <label for="image" class="form-control-label font-weight-bold">@lang('Growth Rate')<sup class="text--danger">*</sup></label>
                                <div class="">
                                    <select name="return_percentage" id="" class="form-control">
                                        <option value="20" <?php if($getHelp->return_percentage == 20){echo "selected";}?>>20%</option>
                                        <option value="30" <?php if($getHelp->return_percentage == 30){echo "selected";}?>>30%</option>
                                        <option value="50" <?php if($getHelp->return_percentage == 50){echo "selected";}?>>50%</option>
                                    </select>
                                   
                                </div>
                            </div>
                           <div class="form-group col-md-6">
                                <label for="image" class="form-control-label font-weight-bold">@lang('Token')<sup class="text--danger">*</sup></label>
                                <div class="">
                                    <input type="text" class="form-control" name="token" value="{{ $getHelp->current_token }}"/>
                                </div>
                            </div>
                           <div class="form-group col-md-6">
                                <label for="image" class="form-control-label font-weight-bold">@lang('Match Provide Help')<sup class="text--danger">*</sup></label>
                                <div class="">
                                    <select name="provide_help" id="">
                                        <option value="">Select One</option>
                                        @foreach($provideHelp as $provideHelps)
                                            <option value="{{$provideHelps->id}}">{{$provideHelps->user->firstname}}-
                                            {{$provideHelps->user->email}}-
                                            {{number_format($provideHelps->amount,2)}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="" class="form-control-label font-weight-bold">@lang('Block this user')</label>
                                    <input type="checkbox" class="" name="block_user" value="0" <?php if(isset(auth()->user()->status)){if(auth()->user()->status == 0){ echo "checked";}}?>/>
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
