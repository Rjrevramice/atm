<header class="header-section"> 
    <div class="container-fluid py-2 header_background">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 d-flex justify-content-md-start justify-content-lg-start justify-content-center icons">
                    @foreach(getContent('social_icon.element') as $data)
                        <div class="mr-4">
                            <a href="{{$data->data_values->url}}" target="_blank">
                            {!! $data->data_values->social_icon !!}
                            </a>
                        </div>   
                    @endforeach
                    <!--<div class="mr-4">
                       <a href="https://twitter.com/" target="_blank"><i class="fab fa-twitter text-white" aria-hidden="true"></i></a>
                    </div>
                    <div class="mr-4">
                      <a href="https://www.instagram.com/" target="_blank"><i class="fab fa-instagram text-white" aria-hidden="true"></i></a>
                    </div> -->
                    <!-- <div class="mr-4">
                      <a href="https://www.linkedin.com/" target="_blank"><i class="fab fa-linkedin-in text-white" aria-hidden="true"></i></a>
                    </div>
                    <div class="">
                      <a href="https://www.youtube.com/" target="_blank"><i class="fab fa-youtube text-white" aria-hidden="true"></i></a>
                    </div> -->
                    <!-- <div class="">
                      <a href="https://www.youtube.com/" target="_blank"><i class="fab fa-telegram text-white" aria-hidden="true"></i></a>
                    </div>  -->
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="header-wrapper">
            <div class="logo">
                <a href="{{route('home')}}"><img src="{{getImage(imagePath()['logoIcon']['path'] .'/logo.png')}}" alt="@lang('logo')"></a>
            </div>
            <ul class="menu">
                <li>
                    <a href="{{route('home')}}">@lang('Home')</a>
               </li>
                <li>
                    @php $encIdea = encrypt('idealogy');@endphp
                    <a href="{{route('idealogy',$encIdea)}}">@lang('Idealogy')</a>
                </li>
                <li>
                    @php $encPlanDetail = encrypt('plan_detail');@endphp
                    <a href="{{route('plan_detail',$encPlanDetail)}}">@lang('Plan Detail')</a>
                </li>
                <li>
                    @php $encContact = encrypt('contact_us');@endphp
                    <a href="{{ route('contact') }}">Enquiry</a>
                </li>
                @foreach($pages as $k => $data)
                    <li><a href="{{route('pages',[$data->slug])}}">{{__($data->name)}}</a></li>
                @endforeach

                
                <!--  <li>
                    <a href="{{route('plan')}}">@lang('Plan')</a>
                </li>

                <li>
                    <a href="{{route('blog')}}">@lang('Blog')</a>
                </li>

                 <li>
                    <a href="{{route('contact')}}">@lang('Contact')</a>
                </li>-->
                @guest
                    <li class="d-md-none">
                        <a href="{{route('user.register')}}" class="custom-button theme py-0 m-1">@lang('Registration')</a>
                    </li>
                    <li class="d-md-none">
                        <a href="{{route('user.login')}}" class="custom-button theme py-0 m-1">@lang('Login')</a>
                    </li>
                @endguest

                @auth
                    <li class="d-md-none">
                        <a href="{{route('user.home')}}" class="custom-button theme py-0 m-1">@lang('Dashboard')</a>
                    </li>
                @endauth
            </ul>
            <div class="right-area ml-lg-4  ml-auto">
               <!-- <select name="language" class="select-bar langSel">
                    @foreach($language as $item)
                        <option value="{{$item->code}}" @if(session('lang') == $item->code) selected  @endif>{{ __($item->name) }}</option>
                    @endforeach
                </select>-->
                @guest
                    
                    <a href="{{route('user.register')}}" class="custom-button theme hover-cl-light align-items-center d-none d-md-flex mr-3"><i class="fas fa-pen mr-2"></i>@lang('Registration')</a>
                   
                    <a href="{{route('user.login')}}" class="custom-button align-items-center theme hover-cl-light d-none d-md-flex"><i class="fas fa-sign-in-alt mr-2"></i>@lang('Login')</a>
                @endguest

                @auth
                    <a href="{{route('user.home')}}" class="custom-button theme hover-cl-light d-none d-md-flex ">@lang('Dashboard')</a>
                @endauth
            </div>
            <div class="header-bar ml-2 ml-md-4">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
</header>