@extends($activeTemplate.'layouts.frontend')
@section('content')
@include($activeTemplate.'partials.breadcrumb')

<!-- products section start -->
<section class="product-section my-md-5 pt-5">
    <div class="container">
       <div class="row">
           <!-- <div class="col-12 text-center">
               <h3 class="main-header">Our Products</h3>
               <div class="row d-flex justify-content-center mt-3">
                   <div class="col-lg-4 col-md-6">
                     <p class=" sub-header">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                   </div>
               </div>
           </div> -->
         
                @foreach($product as $prod)
                    <div class="col-lg-3 col-md-4 col-6   mb-md-5 mb-4">
                        <div class="product-card card bs_1 h-100 border-0 br_10">
                            <a href="http://"><img class="card-img-top" src="{{ getImage('assets/images/frontend/product/'. $prod->image, '350x260')}}" alt="Card image cap"></a>
                            <div class="card-body p-md-3 p-2">
                                <h5 class="card-title"><a href="http://" class="one_line">{{  $prod->name }}</a></h5>
                                <div class="d-md-flex justify-content-between align-items-center p-1">
                                 <p class="card-text font-weight-bold mb-2 mb-md-0">₹{{__($prod->price)}}</p>
                                <div class="qty-input">
                                        <button class="qty-count qty-count--minus" data-action="minus" type="button">-</button>
                                        <input class="product-qty" type="number" name="product-qty" id="qty_{{ $prod->id }}" min="1" max="100" value="1" disabled>
                                        <button class="qty-count qty-count--add" data-action="add" type="button">+</button>
                                    </div>
                                </div>
                                <div class="size_sec mt-3">
                                    <h6 class="d-flex  align-items-center"> Size : <small class="pl-2"><p>{{__($prod->size)}}</p></small></h6>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent border-0 mb-2">
                         @if(Auth::check()) 
                          <button class="btn w-100 addbtn" id="cart" value="1" user_id="{{ auth()->user()->id }}" product_id="{{ $prod->id }}">Add to Cart</button>
                          <input type="hidden" id="product_id" type="number" value="{{ $prod->id }}">
                        <input type="hidden" id="user_id" type="number" value="{{ auth()->user()->id }}" >
                                    @endif
                            </div>
                        </div>
                    </div>
                @endforeach 
                <!-- <div class="col-12 d-flex justify-content-center">
                <a href="{{ route('product') }}"><button  type="submit" id="submit" class="btn border-0 btn-more">View More</button></a>
             </div> -->
            
       </div>
    </div>
</section>
<!-- products section end -->
@endsection

                 
@push('script')
    <script>
        'use strict';
        $(document).on('click','.addbtn' , function(){

        var uid =  $(this).attr('user_id');
        var pid = $(this).attr('product_id');
        var qty = $("#qty_"+pid).val();
        if(qty){
            $.ajax({
                headers: {"X-CSRF-TOKEN": "{{ csrf_token() }}",},
                url:"{{ route('update_product_cart') }}",
                method:"POST",
                data:{user_id:uid,product_id:pid,quantity:qty},
                success:function(data, textStatus, statusCode)
                {
                    if(statusCode.status == 200){
                        notify('success', data.message);
                    }
                }
            });
        }
        });



        // for quantity section
        var QtyInput = (function () {
	var $qtyInputs = $(".qty-input");

	if (!$qtyInputs.length) {
		return;
	}

	var $inputs = $qtyInputs.find(".product-qty");
	var $countBtn = $qtyInputs.find(".qty-count");
	var qtyMin = parseInt($inputs.attr("min"));
	var qtyMax = parseInt($inputs.attr("max"));

	$inputs.change(function () {
		var $this = $(this);
		var $minusBtn = $this.siblings(".qty-count--minus");
		var $addBtn = $this.siblings(".qty-count--add");
		var qty = parseInt($this.val());

		if (isNaN(qty) || qty <= qtyMin) {
			$this.val(qtyMin);
			$minusBtn.attr("disabled", true);
		} else {
			$minusBtn.attr("disabled", false);
			
			if(qty >= qtyMax){
				$this.val(qtyMax);
				$addBtn.attr('disabled', true);
			} else {
				$this.val(qty);
				$addBtn.attr('disabled', false);
			}
		}
	});

	$countBtn.click(function () {
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


  