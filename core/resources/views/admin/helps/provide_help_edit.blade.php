@extends('admin.layouts.app')
@section('panel')
    <div class="row mb-none-30">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                   <form action="{{ route('admin.provide_help.update',$provideHelp->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                      <div class="row aling-items-center">
                            <div class="form-group col-md-6">
                                <label for="name" class="form-control-label font-weight-bold">@lang('User Name')</label>
                                <input type="text" readonly class="form-control form-control-lg" name="name" value="{{__($provideHelp->user->firstname)}}"  maxlength="100" required="">
                            </div>

                           <div class="form-group col-md-6">
                                <label for="image" class="form-control-label font-weight-bold">@lang('Currency')<sup class="text--danger">*</sup></label>
                                <div class="">
                                    <select name="currency" id="" class="form-control">
                                        <option value="INR" <?php if($provideHelp->currency == "INR"){echo "selected";}?>>INR</option>
                                        <option value="USD" <?php if($provideHelp->currency == "USD"){echo "selected";}?>>USD</option>
                                    </select>
                                    
                                </div>
                            </div>
                           <div class="form-group col-md-6">
                                <label for="image" class="form-control-label font-weight-bold">@lang('Amount')<sup class="text--danger">*</sup></label>
                                <div class="">
                                    <input type="text" class="form-control" name="amount" value="{{ $provideHelp->amount }}"/>
                                </div>
                            </div>
                           <div class="form-group col-md-6">
                                <label for="image" class="form-control-label font-weight-bold">@lang('Growth Rate')<sup class="text--danger">*</sup></label>
                                <div class="">
                                    <select name="return_percentage" id="" class="form-control">
                                        <option value="20" <?php if($provideHelp->return_percentage == 20){echo "selected";}?>>20%</option>
                                        <option value="30" <?php if($provideHelp->return_percentage == 30){echo "selected";}?>>30%</option>
                                        <option value="50" <?php if($provideHelp->return_percentage == 50){echo "selected";}?>>50%</option>
                                    </select>
                                   
                                </div>
                            </div>
                           <div class="form-group col-md-6">
                                <label for="image" class="form-control-label font-weight-bold">@lang('Token')<sup class="text--danger">*</sup></label>
                                <div class="">
                                    <input type="text" class="form-control" name="token" value="{{ $provideHelp->current_token }}"/>
                                </div>
                            </div>
                           <div class="form-group col-md-6">
                                <label for="image" class="form-control-label font-weight-bold">@lang('Match Get Help')<sup class="text--danger">*</sup></label>
                                <div class="">
                                    @php $matchId = explode(',',$provideHelp->match_id);@endphp 
                                    <select name="get_help[]" id="get_help" multiple>
                                        <option value="">Select One</option>
                                        @foreach($getHelp as $getHelps)
                                            <option value="{{$getHelps->id}}" <?php if(in_array($getHelps->id,$matchId)){echo "selected";}$matchId?>>{{$getHelps->user->firstname}}-
                                            {{$getHelps->user->email}}-
                                            {{number_format($getHelps->amount,2)}}
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
   
    <script src="{{ asset('assets/admin/js/provide.js') }}"></script>
    <script>
        const get_help = document.getElementById('get_help');
        get_help.addEventListener("change",()=>{
           
        });
    </script>
@endsection

@push('breadcrumb-plugins')
    <a href="{{route('admin.category.index')}}" class="btn btn-sm btn--primary box--shadow1 text--small" ><i class="las la-angle-double-left"></i>@lang('Go Back')</a>
@endpush
