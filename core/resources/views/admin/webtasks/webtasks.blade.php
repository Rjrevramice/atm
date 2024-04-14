@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                      <div>
                        <form action="{{route('admin.upload_a_task')}}" method="post">
                            @csrf
                            <input type="text" class="form-control" name="new_task" required placeholder="Web tasks">
                            <input type="submit" class="btn btn-primary" value="Submit">
                        </form>
                      </div>
                    <table class="table table--light style--two">
        <thead>
            <tr>
                <th>@lang('SI.No')</th>
                <th>@lang('Tasks Url')</th>
                <th>@lang('Created Date')</th>
                <th>@lang('Action')</th>
            </tr>
        </thead>
        <tbody>

        @forelse($webTasks as $data)
            <tr>
                <td>{{  $loop->iteration }}</td>
                <td data-label="@lang('Name')">
                    {{__ ($data->task_url)}}
                </td>
                <td>{{$data->created_at}}</td>
                
                <td data-label="@lang('Action')">
                    <a href="{{route('admin.provide_help.edit', $data->id)}}" class="icon-btn btn--primary">
                        <i class="las la-edit"></i>
                    </a>
                    <button class="icon-btn btn--danger removeBtn ml-2" data-id="{{ $data->id }}"><i class="la la-trash"></i></button>

                    {{-- REMOVE METHOD MODAL --}}
                    <div id="removeModal-{{$loop->iteration}}" class="modal fade" tabindex="-1" role="dialog">
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
                    </div>
                </td>
            </tr>

           
        @empty
        @endforelse
        </tbody>
    </table>
                    </div>
                </div>
                <div class="card-footer py-4">
                    {{ paginateLinks($webTasks) }}
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