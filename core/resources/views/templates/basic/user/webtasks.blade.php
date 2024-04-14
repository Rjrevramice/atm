@extends($activeTemplate.'layouts.master')
@section('content')
@include($activeTemplate.'partials.breadcrumb')


<style>
    .task-head{
        background-color: #4e4eff;
    }
    .task-head th{
        padding: 10px !important;
        font-size: 18px !important;
    }
    .fa-clipboard{
        font-size: 20px !important;
        /* color: blue; */
    }
    .card{
        box-shadow: 0px 0px 20px #cacaff;
        border: none !important;

    }
</style>



<div class="transaction-section my-5 cart-table table-responsive">
     <div class="container">
            <div class=" row my-2 item-rounded">
                
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <table class="deposite-table">
                                <thead class="custom--table">
                                    <tr class="task-head">
                                        <th>NO.</th>
                                        <th>Today Task Link</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
        
                                    <tr >
                                        <td>1.</td>
                                        <td data-label="@lang('Date')"> {{$taskLinks->task_url}}</td>
                                        <td><button id="copyButton" class="btn btn-primary mt-3" onclick="copyToClipboard()">
                                                <i class="far fa-clipboard"></i>copy
                                            </button>
                                        </td>
                                    </tr>
                                    
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 mt-md-0 mt-5">
                    
                    <div class="card">
                        <div class="card-body">
                            <div class="text-right">
                                @php $encSubmitUrl = encrypt('SubmitWebTaskUrl');@endphp
                                <form action="{{route('user.submitWebTasks',$encSubmitUrl)}}" method="post">
                                    @csrf
                                    <input type="text" class="form-lg-control" name="submit_url" class="form-control" placeholder ="Add your submission here..">
                                    <input type="hidden" value="{{$taskLinks->id}}" name="task_id">
                                    <div class="mt-3">
                                        <input type="submit" class="btn btn-primary btn-sm mt-2" value="submit">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
           
            </div>
        </div>
    </div>
    <script>
        function copyToClipboard() {
            const referralCode = '{{$taskLinks->task_url}}'; 
            const textArea = document.createElement('textarea');
            textArea.value = referralCode;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand('copy');
            document.body.removeChild(textArea);
            notify('success', "Url copied to clipboard");
        }
    </script>
@endsection



