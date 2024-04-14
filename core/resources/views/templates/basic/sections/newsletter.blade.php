<form class="">
    <div class="input-group footer-input-filed">
        <input type="email" id="emailSub" class="form-control h-40" placeholder="@lang('Your Email Address')">
        <div class="input-group-append subscribebtn h-40">
            <span class="input-group-text cursor-pointer"><button type="button" class="btn p-0 subscribebtn1"><i class="fas fa-paper-plane text-white"></i></button></span>
        </div>
    </div>
</form>
                   
@push('script')
    <script>
        'use strict';
        $(document).on('click','.subscribebtn1' , function(){
            var email = $("#emailSub").val();
            if(email){
                $.ajax({
                    headers: {"X-CSRF-TOKEN": "{{ csrf_token() }}",},
                    url:"{{ route('subscribe') }}",
                    method:"POST",
                    data:{email:email},
                    success:function(response)
                    {
                        if(response.success) {
                            notify('success', response.success);
                            $("#emailSub").val('');
                        }else{
                            $.each(response, function (i, val) {
                                notify('error', val);
                            });
                        }
                    }
                });
            }
            else{
                notify('error', "Please Input Your Email");
            }
        });
    </script>
@endpush