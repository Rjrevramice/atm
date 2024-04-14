@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('SI.No')</th>
                                    <th>@lang('User Name')</th>
                                    <th>@lang('Currency')</th>
                                     <th>@lang('Amount')</th>
                                     <th>@lang('Growth Rate(%)')</th>
                                     <th>@lang('Token')</th>
                                     <th>@lang('Time')</th>
                                     <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>

                            @forelse($provideHelp as $data)
                               
                                <tr>
                                    <td>{{  $loop->iteration }}</td>
                                    <td data-label="@lang('Name')">
                                        {{__ ($data->user->firstname)}}
                                    </td>

                                    <td data-label="@lang('currency')">
                                        {{$data->currency}}
                                    </td>
                                    <td>{{$data->amount}}</td>
                                    <td>{{$data->return_percentage}}</td>
                                    <td><span class="badge badge-pill badge-secondary">{{$data->current_token}}</span></td>
                                    <td></td>
                                <td data-label="@lang('Action')">
                                        <a href="{{route('admin.get_help.edit', $data->id)}}" class="icon-btn btn--primary">
                                            <i class="las la-edit"></i>
                                        </a>
                            <button class="icon-btn btn--danger removeBtn ml-2" data-id="{{ $data->id }}"><i class="la la-trash"></i></button>

                        {{-- REMOVE METHOD MODAL --}}
                        <div id="removeModal" class="modal fade" tabindex="-1" role="dialog">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">@lang('Confirmation')</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('admin.category.remove') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id">
                                        <div class="modal-body">
                                            <p class="font-weight-bold">@lang('Are you sure to delete this item? Once deleted can not be undone.')</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                                            <button type="submit" class="btn btn--danger">@lang('Remove')</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>  </td>
                                 </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">No Data Found</td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer py-4">
                    {{ paginateLinks($provideHelp) }}
                </div>
            </div>
        </div>
    </div>

@endsection

@push('breadcrumb-plugins')


    <!-- <a href="{{route('admin.category.create')}}" class="btn btn-md btn--primary box--shadow1 text--small addPlan"><i class="las la-plus"></i>@lang('Add Category')</a> -->
@endpush


@push('script')
<script>
    function getTimeFormat(minutes) {
        let hours = Math.floor(minutes / 60);
        let remainingMinutes = minutes % 60;
        let timeFormat = '';

        if (hours > 0) {
            timeFormat += hours + 'hrs ';
        }

        timeFormat += 'to ' + remainingMinutes + ' mins';
        return timeFormat;
    }
</script>

    <script>
        (function ($) {
            "use strict";
            $('.removeBtn').on('click', function () {
                var modal = $('#removeModal');
                modal.find('input[name=id]').val($(this).data('id'))
                modal.modal('show');
            });

            $('.addBtn').on('click', function () {
                var modal = $('#addModal');
                modal.modal('show');
            });

            $('.updateBtn').on('click', function () {
                var modal = $('#updateBtn');
                modal.find('input[name=id]').val($(this).data('id'));

                var obj = $(this).data('all');
                var images = $(this).data('images');
                if (images) {
                    for (var i = 0; i < images.length; i++) {
                        var imgloc = images[i];
                        $(`.imageModalUpdate${i}`).css("background-image", "url(" + imgloc + ")");
                    }
                }
                $.each(obj, function (index, value) {
                    modal.find('[name=' + index + ']').val(value);
                });

                modal.modal('show');
            });

            $('#updateBtn').on('shown.bs.modal', function (e) {
                $(document).off('focusin.modal');
            });
            $('#addModal').on('shown.bs.modal', function (e) {
                $(document).off('focusin.modal');
            });

            $('.iconPicker').iconpicker().on('change', function (e) {
                $(this).parent().siblings('.icon').val(`<i class="${e.icon}"></i>`);
            });
        })(jQuery);
    </script>

@endpush