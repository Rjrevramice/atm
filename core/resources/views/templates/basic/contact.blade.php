@extends($activeTemplate.'layouts.frontend')
@section('content')
@php
    $content = getContent('contact_us.content', true);
@endphp
@include($activeTemplate.'partials.breadcrumb')
    <div class="contact-section my-5 py-md-3">
        <div class="container">
            <div class="row g-4 justify-content-center">
                <!-- <div class="col-lg-4 col-md-6 mb-lg-0 mb-3">
                    <div class="contact__item card border-0 h-100 bs_1 p-3 br_10">
                        <div class="card-body d-flex justify-content-start align-items-center p-0">
                            <div class="contact__icon">
                                <i class="fas fa-phone contact__info__transform"></i>
                            </div>
                            <div class="contact__body">
                                <h5 class="contact__title">@lang('Phone')</h5>
                                <ul class="contact__info">
                                    <li>
                                        <a href="Tel:{{@$content->data_values->contact_number}}">{{__(@$content->data_values->contact_number)}}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-lg-0 mb-3">
                    <div class="contact__item card border-0 h-100 bs_1 p-3 br_10">
                        <div class="card-body d-flex justify-content-start align-items-center p-0">
                            <div class="contact__icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="contact__body">
                                <h5 class="contact__title">@lang('Email')</h5>
                                <ul class="contact__info">
                                    <li>
                                        <a href="mailto:{{__(@$content->data_values->email_address)}}">{{__(@$content->data_values->email_address)}}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-lg-0 mb-3">
                    <div class="contact__item card border-0 h-100 bs_1 p-3 br_10">
                        <div class="card-body d-flex justify-content-start align-items-center p-0">
                            <div class="contact__icon">
                                <i class="fas fa-map-marker"></i>
                            </div>
                            <div class="contact__body">
                                <h5 class="contact__title">@lang('Address')</h5>
                                <ul class="contact__info">
                                    <li>
                                        <a href="javascript:void(0)">{{__(@$content->data_values->contact_address)}}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>
            <div class="contact-wrapper bg-transparant mt-4 p-md-4 p-3 card h-100 border-0 bs_1">
                <h3 class="title text-center mb-20 mb-lg-4">{{__(@$content->data_values->title)}}</h3>
                <form class="contact-form row mb--25" action="" method="POST">
                    @csrf
                    <div class="col-md-6">
                        <div class="contact-form-group">
                            <label for="name">@lang('Name')</label>
                            <input type="text" placeholder="@lang('Enter Name')" id="name" value="@if(auth()->user()) {{ auth()->user()->fullname }} @else{{ old('name') }}@endif" @if(auth()->user()) readonly @endif required name="name">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="contact-form-group">
                            <label for="email">@lang('Email')</label>
                            <input type="email" placeholder="@lang('Enter Email')" id="email" value="@if(auth()->user()) {{ auth()->user()->email }} @else {{old('email')}} @endif"   @if(auth()->user()) readonly @endif required name="email">
                        </div>
                    </div>
                   
                    <div class="col-md-12">
                        <div class="contact-form-group">
                            <label for="subject">@lang('Subject')<span class="text-danger pl-1">*</span></label>
                            <input type="text" placeholder="@lang('Enter Subject')" id="subject" value="{{old('subject')}}" required name="subject">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="contact-form-group">
                            <label for="message">@lang('Message')<span class="text-danger pl-1">*</span></label>
                            <textarea name="message" id="message" placeholder="@lang('Enter Message')" required="">{{old('message')}}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6 offset-md-6 text-right">
                        <div class="contact-form-group">
                            <button type="submit">@lang('Send Message')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection