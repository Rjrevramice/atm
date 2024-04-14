@extends($activeTemplate . 'layouts.frontend')
@section('content')


<style>
    .header_background .fab{
        color: white !important;
    }
    .logo img{
        width: 80px;
    }
</style>


    @php
        $content = getContent('banner.content', true);

    @endphp
    <section class="oh bg_img primary-overlay"
        {{-- data-background="{{ getImage('assets/images/frontend/banner/' . @$content->data_values->background_image, '1200x798') }}"> --}}
        data-background="{{ getImage('assets/images/frontend/static/i2.jpg') }}">
    </section>
    <!-- double banner section start -->
    <section class="my-md-5 py-md-3 mt-4">
        <div class="container">
            <div class="row double_banner">
                {{-- @foreach ($category as $cat)
                    <div class="col-lg-6 col-12 mb-lg-0 mb-md-4 mb-3">
                        <div class="double-banner-1"
                            style="background-image:url({{ getImage('assets/images/frontend/category/' . $cat->image, '150x160') }})">
                            <div class="double-banner-content d-block pl-md-4 pl-3">
                                <h5>{{ $cat->name }} </h5>
                                <a href=" {{ route('user.home') }}">Help</a>
                            </div>
                        </div>
                    </div>
                @endforeach --}}

                <div class="col-lg-6 col-12 mb-lg-0 mb-md-4 mb-3">
                    <div class="double-banner-1"
                        style="background-image:url({{ getImage('assets/images/frontend/static/i5.jpg') }})">
                        <div class="double-banner-content d-block pl-md-4 pl-3">
                            <h5 class="text-uppercase text-light">Provide Help</h5>
                            <a href=" {{ route('user.home') }}" class="text-light">Provide Help</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-12 mb-lg-0 mb-md-4 mb-3">
                    <div class="double-banner-1"
                        style="background-image:url({{ getImage('assets/images/frontend/static/i6.png') }})">
                        <div class="double-banner-content d-block pl-md-4 pl-3">
                            <h5 class="text-uppercase">Get Help </h5>
                            <a href=" {{ route('user.home') }}">Get Help</a>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </section>
    <!-- double banner section end -->

    <style>
        .plans{
            height: 20rem;
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            display: flex;
            align-items: center;
        }
    </style>

    <!-- single banner start -->
    <section class="single-banner my-md-5 py-md-5">
        <div class="container-fluid  px-0">
            <div class="row">
                <div class="col-lg-12">
                    {{-- <img src="{{ getImage('assets/images/frontend/auth/fasion.png') }} " alt=""> --}}
                    
                    <div style="background-image: url({{ getImage('assets/images/frontend/static/i4.jpg') }});" class="plans">
                        {{-- <img src="{{ getImage('assets/images/frontend/static/i4.jpg') }} " alt=""> --}}
                        <div class="container">
                            <h2 class="text-light">Our Plan Details</h2>
                            <?php $en = encrypt('ttt'); ?>
                            <div class="mt-4">
                                <a href="{{route('plan_detail',$en)}}">
                                    <button class="btn btn-primary">See Plans</button>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- single banner end -->



    <style>
        .owl-carousel {
            display: block !important;
        }
        .owl-nav{
            display: none;
        }
    </style>


    <section class="product-section my-md-5 mb-4">
        <div class="container">
        <div class="row">
           
            <div class="col-12 text-center my-5">
                
                <h3>Testimonials</h3>
                <small>Our Clients</small>

            </div>
            
            <div class="col-lg-12">
                <div class="owl-carousel owl-theme carousel_width">
                    @php
                        $blogs = App\Models\Frontend::where('data_keys','blog.element')->get(); 
                    @endphp

                    @foreach ($blogs as $item)

                            <div class="item">
                                <div class="card text-left">
                                  <div class="cardo">
                                    <img class="card-img-top mt-2" src="{{getImage('assets/images/frontend/blog/'.$item->data_values->blog_image)}}" alt="">
                                    <div class="card-body text-center">
                                        <h6 class="card-title text-bold">{{$item->data_values->title}}</h6>
                                        <p>{!! $item->data_values->description_nic !!}</p>
                                    </div>
                                  </div>
                                </div>
                            </div>
                        
                    @endforeach            
                </div>
            </div>
        </div>
    </div>
</section>



















    <!-- products section start -->
    {{-- <section class="product-section my-md-5 mb-4">
        <div class="container">
            {{-- <div class="row"> --}}
                {{-- <div class="col-12 text-center">
                    <h3 class="main-header">Our Products</h3>
                    <div class="row d-flex justify-content-center mt-3">
                        <div class="col-lg-4 col-md-6">
                            <p class=" sub-header">Lorem Ipsum is simply dummy text of the printing and typesetting
                                industry.</p>
                        </div>
                    </div>
                </div>
                <div class="row mt-5 px-3"> --}}
                    {{-- @foreach ($products as $product)
                        <div class="col-lg-3 col-md-4 col-6  mb-md-5 mb-4">
                            <div class="product-card card bs_1 h-100 border-0 br_10">
                                <a href="#" data-toggle="modal" data-target="#largeModal{{ $product->id }}"><img
                                        class="card-img-top"
                                        src="{{ getImage('assets/images/frontend/product/' . $product->image, '350x260') }}"
                                        alt="Card image cap"></a>
                                <div class="card-body p-md-3 p-2">
                                    <h5 class="card-title"><a href="#" data-toggle="modal"
                                            data-target="#largeModal{{ $product->id }}"
                                            class="one_line">{{ $product->name }}</a></h5>
                                    <div class="d-md-flex justify-content-between align-items-center p-1">
                                        <p class="card-text font-weight-bold mb-2 mb-md-0">₹{{ __($product->price) }}</p>

                                        @if (Auth::check())
                                            <div class="qty-input">
                                                <button class="qty-count qty-count--minus" data-action="minus"
                                                    type="button">-</button>
                                                <input class="product-qty" type="number" name="product-qty" min="1"
                                                    id="qty_{{ $product->id }}" max="100" value="1" disabled>
                                                <button class="qty-count qty-count--add" data-action="add"
                                                    type="button">+</button>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="size_sec mt-3">
                                        <h6 class="d-flex  align-items-center"> Size : <small class="pl-2">
                                                <p>{{ __($product->size) }} </p>
                                            </small></h6>
                                    </div> --}}
                                {{-- </div>
                                <div class="card-footer bg-transparent border-0 mb-2">
                                    <!-- @if (Auth::check()) 
    -->
                                    {{-- <button class="btn w-100 addbtn" id="cart" value="1"
                                        user_id="{{ auth()->user()->id }}" product_id="{{ $product->id }}">Add to
                                        Cart</button>
                                    <!-- <input type="text" id="demoInput" type="number" min="1" max="100">
                                <input type="hidden" id="product_id" type="number" value="{{ $product->id }}">
                                <input type="hidden" id="user_id" type="number" value="{{ auth()->user()->id }}" > -->
                                    <!--
    @endif -->
                                </div>
                            </div>
                        </div>

                        <!-- modal for product view images start--> --}}
                        {{-- <div class="modal fade" id="largeModal{{ $product->id }}" tabindex="-1" role="dialog"
                            aria-labelledby="basicModal" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="myModalLabel">{{ $product->name }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <img class="card-img-top"
                                            src="{{ getImage('assets/images/frontend/product/' . $product->image, '350x260') }}"
                                            alt="Card image cap">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-theme modal-btn text-white"
                                            data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div> 
                        <!-- modal for product view images end-->
                    {{-- @endforeach
                    <div class="col-12 d-flex justify-content-center">
                        <a href="{{ route('product') }}"><button type="submit" id="submit"
                                class="btn border-0 btn-more">View More</button></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- products section end -->






    {{-- <section class="feature-section">
    <div class="container">
        <div class="section-header cl-white">
            <h2 class="title">Our Category</h2>
           
        </div>

  <div class="row justify-content-center">

               @foreach ($category as $cat)
                <div class="col-sm-10 col-md-6 col-lg-4">
                    <div class="feature-item">
                        <div class="feature-thumb">
                          {{  $cat->name }} 
                        </div>
                        <div class="feature-content">
                         <p>
                           <img src="{{ getImage('assets/images/frontend/category/'. $cat->image, '150x160')}}" alt="cat">
                       </p>
                        </div>
                     </div>
                </div>
             @endforeach 

   </div>

 <div class="section-header cl-white">
    <h2 class="title">Our Products</h2>
 </div>

        <div class="row justify-content-center">

               @foreach ($products as $product)
                <div class="col-sm-10 col-md-6 col-lg-4">
                    <div class="feature-item">
                        <div class="feature-thumb">
                          {{  $product->name }} 
                        
                        </div>
                        <div class="feature-content">
                            <p>
                                    <img src="{{ getImage('assets/images/frontend/product/'. $product->image, '350x260')}}" alt="product">
                             </p>
                            <p>{{__($product->price)}}</p>
                           </div>
                    </div>
                </div>

            @endforeach 

        </div>
    </div>
</section> --}}



    <?php /*	
    @if($sections->secs != null)
        @foreach(json_decode($sections->secs) as $sec)
            @include($activeTemplate.'sections.'.$sec)
        @endforeach
    @endif
	*/
    ?>
@endsection


@push('script')
    <script>
        'use strict';
        $(document).on('click', '.addbtn', function() {

            var uid = $(this).attr('user_id');
            var pid = $(this).attr('product_id');
            var qty = $("#qty_" + pid).val();
            if (qty) {
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    },
                    url: "{{ route('update_product_cart') }}",
                    method: "POST",
                    data: {
                        user_id: uid,
                        product_id: pid,
                        quantity: qty
                    },
                    success: function(data, textStatus, statusCode) {
                        if (statusCode.status == 200) {
                            notify('success', data.message);
                        }
                    }
                });
            }
        });



        // for quantity section
        var QtyInput = (function() {
            var $qtyInputs = $(".qty-input");

            if (!$qtyInputs.length) {
                return;
            }

            var $inputs = $qtyInputs.find(".product-qty");
            var $countBtn = $qtyInputs.find(".qty-count");
            var qtyMin = parseInt($inputs.attr("min"));
            var qtyMax = parseInt($inputs.attr("max"));

            $inputs.change(function() {
                var $this = $(this);
                var $minusBtn = $this.siblings(".qty-count--minus");
                var $addBtn = $this.siblings(".qty-count--add");
                var qty = parseInt($this.val());

                if (isNaN(qty) || qty <= qtyMin) {
                    $this.val(qtyMin);
                    $minusBtn.attr("disabled", true);
                } else {
                    $minusBtn.attr("disabled", false);

                    if (qty >= qtyMax) {
                        $this.val(qtyMax);
                        $addBtn.attr('disabled', true);
                    } else {
                        $this.val(qty);
                        $addBtn.attr('disabled', false);
                    }
                }
            });

            $countBtn.click(function() {
                var operator = this.dataset.action;
                var $this = $(this);
                var $input = $this.siblings(".product-qty");
                var qty = parseInt($input.val());

                if (operator == "add") {
                    qty += 1;
                    if (qty >= qtyMin + 1) {
                        $this.siblings(".qty-count--minus").attr("disabled", false);
                    }

                    if (qty >= qtyMax) {
                        $this.attr("disabled", true);
                    }
                } else {
                    qty = qty <= qtyMin ? qtyMin : (qty -= 1);

                    if (qty == qtyMin) {
                        $this.attr("disabled", true);
                    }

                    if (qty < qtyMax) {
                        $this.siblings(".qty-count--add").attr("disabled", false);
                    }
                }

                $input.val(qty);
            });
        })();
    </script>
@endpush
