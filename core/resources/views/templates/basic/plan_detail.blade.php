@extends($activeTemplate.'layouts.frontend')
@section('content')
@php
    $content = getContent('contact_us.content', true);
@endphp
@include($activeTemplate.'partials.breadcrumb')

<style>
    .bg{

        background-color: #4e4eff !important;

    }
    .p-text .p,.pp{
        border-bottom: 1px solid #cdcdcd !important;
        font-size: 20px !important;
    }
</style>

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
            <div class="contact-wrapper bg-transparant mt-4 p-md-4 p-3 card h-100 border-0 ">

                <div class="row">
                    
                    <div class="col-12 mb-5 text-center">
                        <h5> THE ATM GROWING RATES</h5>
                        <small>Grab the opportunity</small>
                    </div>

                    <div class="col-lg-4 mt-lg-0">
                        <div class="card bs_1">
                            <div class="card-header text-center bg">
                                <h6 class="text-light">Providing Help Amount</h6>
                            </div>
                            <div class="card-body p-0 m-0">
                                <div class="text-center p-text">
                                    <p class="p p-3">20$ to 1000$</p>
                                    <p class="p p-3">1010$ to 2000$</p>
                                    <p class="p p-3">2010$ to 5000$</p>
                                    <p class="pp p-3">5010$ to 10000$</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 mt-lg-0 mt-5">
                        <div class="card bs_1">
                            <div class="card-header text-center bg">
                                <h6 class="text-light">Monthly growth</h6>
                            </div>
                            <div class="card-body p-0 m-0">
                                <div class="text-center p-text">
                                    <p class="p p-3">30%</p>
                                    <p class="p p-3">45%</p>
                                    <p class="p p-3">60%</p>
                                    <p class="pp p-3">75%</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 mt-lg-0 mt-5">
                        <div class="card bs_1">
                            <div class="card-header text-center bg">
                                <h6 class="text-light">Daily growth</h6>
                            </div>
                            <div class="card-body p-0 m-0">
                                <div class="text-center p-text">
                                    <p class="p p-3">1%</p>
                                    <p class="p p-3">1.5%</p>
                                    <p class="p p-3">2%</p>
                                    <p class="pp p-3">2.5%</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



           
            </div>
        </div>
    </div>
@endsection