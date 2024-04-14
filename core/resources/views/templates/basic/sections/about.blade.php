@php
    $content = getContent('about.content', true);
@endphp
<section class="about-section my-5 py-md-3">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="about-content mb-lg-0 mb-4">
                    <div class="section-header margin-olpo left-style">
                        <h2 class="title">{{__(@$content->data_values->heading)}}</h2>
                        <p>{{__(@$content->data_values->sub_heading)}}</p>
                    </div>
                    <p>{{__(@$content->data_values->description)}}</p>
                    <a href="{{url(@$content->data_values->button_url)}}" class="theme-button ">{{__(@$content->data_values->button_name)}}</a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="video-wrapper w-100 h-100  bg_img"
                     data-background="{{ getImage('assets/images/frontend/about/'. @$content->data_values->video_background_image, '594x400')}}">
                    <a href="{{@$content->data_values->video_link}}" class="video-button popup"><i class="fas fa-play"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>