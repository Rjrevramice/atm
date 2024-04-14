@extends($activeTemplate.'layouts.frontend')
@section('content')



<div class="container my-5 table-responsive cart-table" style="height:50vh">
<h5 class="text-left mb-3 font-weight-bold">{{$pageTitle}}</h5>
    <div class="row">
        <div class="col-12">
            <table id="cart" class="table table-bordered ">
                <thead class="thead-light">
                    <tr>
                        <th>Products</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th class="text-center">Refresh</th>
                        <th class="text-center">Subtotal</th>
                        <th class="text-center">Remove</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $total = 0;?>
                    <?php if(count($cartItems) > 0){?>
                   
                    @foreach($cartItems as $details)
                    <?php 
                    $total +=$details->price * $details->quantity;
                    
                    ?>
                        <div class="row">
                            <tr>
                                <td>
                                    <h6 class="nomargin table-row-header">{{ $details->name }}</h6>
                                </td>
                                <td data-th="Price">{{ $details->price }}</td>
                                <td data-th="Quantity">
                                    <!-- <input type="number" value="{{ $details->quantity }}" class="form-control quantity update_cart" /> -->
                                    <div class="qty-input">
                                        <button class="qty-count qty-count--minus" data-action="minus" type="button">-</button>
                                        <input class="product-qty" type="number" value="{{ $details->quantity }}" name="product-qty" min="1" id="qty_{{ $details->id }}" max="100"  disabled>
                                        <button class="qty-count qty-count--add" data-action="add" type="button">+</button>
                                    </div>
                                </td>
                                <td class="text-center"> <button class="btn btn-info btn-theme1 h-100 update-cart"  cart_id="{{ $details->id }}"><i class="las la-redo-alt"></i></button></td>
                                <td data-th="Subtotal" class="text-center">{{ $details->price * $details->quantity }}</td>
                                <td class="actions text-center" data-th="">
                                    <button class="btn btn-danger h-100 btn-red  remove-from-cart" type="button" cart_id="{{ $details->id }}"><i class="las la-trash"></i></button>
                                </td>
                            </tr>
                        </div>
                        @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4"><h6 class="table-row-header">Total</h6></td>
                        <td colspan=""><h6 class="table-row-header text-center"><input type="hidden" name="overall_total" id="overall_total" value="{{ $total }}"><input type="hidden" name="checkout_user_id" id="checkout_user_id" value="{{ auth()->user()->id }}"> {{ $total }}</h6></td>
                    </tr>
                </tfoot>
                <?php }else{ ?>
                        <tr>
                            <td colspan="10" class="text-center font-weight-bold">No Products In Cart</td>
                        <tr>
                <?php    }?>    
            </table>
        </div>
        <?php if(count($cartItems) > 0){?>
        <div class="col-12 mb-3 d-flex justify-content-end align-items-center">
            <button class="btn btn-success ml-2 text-white btn-theme px-5 checkout_btn" type="button">Checkout</button>
        </div>
        <?php }?>
    </div>
</div>
@endsection


@push('script')
    <script>
        'use strict';
    $(document).on('click','.update-cart' , function(){

        var cartid =  $(this).attr('cart_id');
        var qty = $("#qty_"+cartid).val();
        if(qty){
            $.ajax({
                headers: {"X-CSRF-TOKEN": "{{ csrf_token() }}",},
                url:"{{ route('update_product_cart_page') }}",
                method:"POST",
                data:{cart_id:cartid,quantity:qty},
                success:function(data, textStatus, statusCode)
                {
                    // if(statusCode.status == 200){
                    //     notify('success', data.message);
                    // }
                    location.reload();
                }
            });
        }
        });
        $(document).on('click','.remove-from-cart' , function(){

            var cartid =  $(this).attr('cart_id');
           
                $.ajax({
                    headers: {"X-CSRF-TOKEN": "{{ csrf_token() }}",},
                    url:"{{ route('delete_from_cart') }}",
                    method:"POST",
                    data:{cart_id:cartid},
                    success:function(data, textStatus, statusCode)
                    {
                        location.reload();
                    }
                });
        });    
        
    $(document).on('click','.checkout_btn' , function(){
        var overall_total =  $('#overall_total').val();
        var checkout_user_id =  $('#checkout_user_id').val();
        
       
            $.ajax({
                headers: {"X-CSRF-TOKEN": "{{ csrf_token() }}",},
                url:"{{ route('checkout_update') }}",
                method:"POST",
                data:{total:overall_total,user_id:checkout_user_id},
                success:function(data, textStatus, statusCode)
                {
                    if(statusCode.status == 200){
                        $('.checkout_btn').attr("disabled",true);
                        notify('success', data.message);
                    }
                    setTimeout(
                        function() 
                        {
                             location.reload();
                        }, 2000);
                  ;
                }
            });
     
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

