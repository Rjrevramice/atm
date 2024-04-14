@php
    $content = getContent('how_to_work.content', true);
    $elements = getContent('how_to_work.element', false);
@endphp
<section class="how-section mb-5 pb-md-3">
    <div class="container">
        <div class="section-header">
            <h2 class="title">{{__(@$content->data_values->heading)}}</h2>
            <p>{{__(@$content->data_values->sub_heading)}}</p>
        </div>
        <div class="how-wrapper m-0">
            <div class="row">
                @foreach($elements as $element)
                    <div class="col-lg-3 col-md-6 col-sm-6 mb-lg-0 mb-md-5 mb-3">
                        <div class="how-item card h-100 bs_1 text-center">
                            <div class="d-flex justify-content-center mt-3">
                                <div class="how-thumb">
                                    @php echo $element->data_values->work_icon @endphp
                                </div>
                            </div>
                            <div class="card-body p-4">
                            <div class="how-content">
                                <h5 class="title">{{__($element->data_values->title)}}</h5>
                                <p>{{__($element->data_values->sub_title)}}</p>
                            </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>