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
                                    <th>@lang('PIN')</th>
                                    <th>@lang('Amount')</th>
                                   <th>@lang('Status')</th>
                                    <!-- <th>@lang('Action')</th> -->
                                </tr>
                            </thead>
                            <tbody>

                            @forelse($gpin as $gp)
                               
                                <tr>
                                     <td>{{  $loop->iteration }}</td>
                                    <td data-label="@lang('Name')">
                                        {{__ ($gp->value)}}
                                    </td>
                                    <td data-label="@lang('Amount')">
                                        {{__ ($gp->amount)}}
                                    </td>
                                <td data-label="@lang('Status')">
                                        @if($gp->status == 1)
                                            <span class="badge badge--success">@lang('Enable')</span>
                                        @else
                                            <span class="badge badge--danger">@lang('Disabled')</span>
                                        @endif
                                    </td>
<?php /*?>
                                  <td data-label="@lang('Action')">
                                       
                            <button class="icon-btn btn--danger removeBtn" data-id="{{ $gp->id }}"><i class="la la-trash"></i></button>

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
                                    <form action="{{ route('admin.generatepin.remove') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id">
                                        <div class="modal-body">
                                            <p class="font-weight-bold">@lang('Are you sure to delete this pin? Once deleted can not be undone.')</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn--danger">@lang('Remove')</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>  </td>
                        <?php */?>
                                 </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{__($emptyMessage) }}</td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer py-4">
                    {{ paginateLinks($gpin) }}
                </div>
            </div>
        </div>
    </div>

@endsection

@push('breadcrumb-plugins')


    <a href="{{route('admin.generatepin.create')}}" class="btn btn-md btn--primary box--shadow1 text--small addgp"><i class="las la-plus"></i>@lang('Set Pin')</a>
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