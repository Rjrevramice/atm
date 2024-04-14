@php
    $content = getContent('footer.content', true);
    $footer_menu = getContent('policy_pages.element', false);
    $socialIcons = getContent('social_icon.element', false);
    $cookie = App\Models\Frontend::where('data_keys','cookie.data')->first();
@endphp

@if(@$cookie->data_values->status && !session('cookie_accepted'))
    <div class="cookie__wrapper bg-dark py-5">
        <div class="container">
          <div class="d-flex flex-wrap align-items-center justify-content-between">
            <p class="txt my-2">
               @php echo @$cookie->data_values->description @endphp
              <a href="{{ @$cookie->data_values->link }}" class="text-theme" target="_blank">@lang('Read Policy')</a>
            </p>
              <a href="javascript:void(0)" class="theme-button  my-2 border-0 text--white policy">@lang('Accept')</a>
          </div>
        </div>
    </div>
 @endif

<!-- <footer class="padding-top primary-overlay bg_img" data-background="{{ getImage('assets/images/frontend/footer/'. @$content->data_values->background_image, '1000x421')}}"> -->
<footer class="bg-footer">
    <div class="footer-top my-md-3 py-md-5 d-lg-block d-none">
        <div class="container">
            <div class="row align-items-start">
                <div class="col-md-3">
                      <div class="footer-logo-img mb-md-4"><a href="{{route('home')}}">
                        <img src="{{getImage(imagePath()['logoIcon']['path'] .'/logo.png')}}" alt="@lang('images')">
                    </a></div>
                    <p class="text-justify footer-list">{{__(@$content->data_values->heading)}}</p>
                </div>
                <!-- <div class="col-md-3 pl-5"> -->
                    <!-- <h5 class="mb-md-4 footer-header">Useful Links</h5> -->
                    <!-- <ul class="footer-list">
                        @foreach($footer_menu as $value)
                        <li><a href="{{route('footer.menu', [slug($value->data_values->menu), $value->id])}}">{{__($value->data_values->menu)}}</a></li>
                        @endforeach
                    </ul> -->
                <!-- </div> -->
                <div class="col-md-3 pl-5">
                <h5 class="mb-md-4 footer-header">Company</h5>
                   <ul class="footer-list">
                        <li><a href="{{ route('home') }}">Home</a> </li>
                        @foreach($pages as $k => $data)
                    <li><a href="{{route('pages',[$data->slug])}}">{{__($data->name)}}</a></li>
                     @endforeach
                        <!-- <li><a href="{{ route('product') }}">Products</a></li> -->
                      <!--  <li><a href="{{ route('contact') }}">Contact Us</a></li>-->
                        <li><a href="{{ route('user.login') }}">Login</a></li>
                    </ul>
                </div>
                <!-- <div class="col-md-3 footer-header">
                 <h5 class="mb-md-4 footer-header">NewsLetter signUp</h5>
                 <p class="footer-list mb-3">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                 @include('templates.basic.sections.newsletter')
                </div> -->
               
            </div>
        
        </div>
    </div>

    <div id="accordion" class="footer-accordion d-lg-none d-block">
        <div class="card bg-transparent border-0">
            <div class="card-header bg-transparent pb-0 border-0" id="headingThree">
                <h5 class="mb-0  ">
                    <button class="btn btn-link collapsed text-left w-100 p-0 d-flex justify-content-between align-items-center" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">About Us <i class="fa fa-angle-right "></i></button>
                </h5>
            </div>
            <div id="collapseThree" class="collapse  show" aria-labelledby="headingThree" data-parent="#accordion">
                <div class="card-body pt-0 pb-0">
                    <div class="footer-logo-img">
                        <a href="{{route('home')}}"><img src="{{getImage(imagePath()['logoIcon']['path'] .'/logo.png')}}" alt="@lang('images')" class="mb-3"></a>
                        <p class="text-justify footer-list">{{__(@$content->data_values->heading)}}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card bg-transparent border-0">
            <div class="card-header bg-transparent border-0 pb-0"  id="headingOne">
            <h5 class="mb-0">
                <button class="btn btn-link collapsed text-left w-100 p-0 d-flex justify-content-between align-items-center" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                Useful Links <i class="fa fa-angle-right "></i>
                </button>
            </h5>
            </div>
            <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
            <div class="card-body pt-0 pb-0">
                <ul class="footer-list">
                        @foreach($footer_menu as $value)
                            <li><a href="{{route('footer.menu', [slug($value->data_values->menu), $value->id])}}">{{__($value->data_values->menu)}}</a></li>
                        @endforeach
                    </ul>
            </div>
            </div>
        </div>
        <div class="card bg-transparent border-0">
            <div class="card-header bg-transparent border-0 pb-0" id="headingTwo">
            <h5 class="mb-0">
                <button class="btn btn-link collapsed text-left w-100 p-0 d-flex justify-content-between align-items-center" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                Company <i class="fa fa-angle-right "></i>
                </button>
            </h5>
            </div>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
            <div class="card-body pt-0 pb-0">
                <ul class="footer-list">
                    <li><a href="{{ route('home') }}">Home</a> </li>
                    @foreach($pages as $k => $data)
                <li><a href="{{route('pages',[$data->slug])}}">{{__($data->name)}}</a></li>
                    @endforeach
                    <!-- <li><a href="{{ route('product') }}">Products</a></li> -->
                    <!--<li><a href="{{ route('contact') }}">Contact Us</a></li>-->
                    <li><a href="{{ route('user.login') }}">Login</a></li>
                </ul>
            </div>
            </div>
        </div>
        <div class="card bg-transparent border-0">
            <div class="card-header bg-transparent border-0 " id="headingfour">
            <!-- <h5 class="mb-0">
                <button class="btn btn-link collapsed text-left w-100 p-0 d-flex justify-content-between align-items-center" data-toggle="collapse" data-target="#collapsefour" aria-expanded="false" aria-controls="collapsefour">
                NewsLetter signUp <i class="fa fa-angle-right "></i>
                </button>
            </h5> -->
            </div>
            <div id="collapsefour" class="collapse" aria-labelledby="headingfour" data-parent="#accordion">
            <div class="card-body pt-0 pb-4">
                <p class="footer-list mb-3">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                  @include('templates.basic.sections.newsletter')
            </div>
            </div>
        </div>
   </div>
    <div class="footer-bottom">
        <div class="container">
            <p>&copy; @lang('All Right Reserved By') <a href="{{route('home')}}" class="text-white">{{__($general->sitename)}}</a></p>
        </div>
    </div>
</footer>



@push('script')
    <script>
        'use strict';
        $('.policy').on('click',function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.get('{{route('cookie.accept')}}', function(response){
                $('.cookie__wrapper').addClass('d-none');
                iziToast.success({message: response, position: "topRight"});
            });
        });
    </script>
@endpush