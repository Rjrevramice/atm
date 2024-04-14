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
                                    <th>@lang('Si.No')</th>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Category Name')</th>
                                    <th>@lang('Short Description')</th>
                                    <th>@lang('Long Description')</th>
                                    <th>@lang('Material Type')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Image')</th>
                                    <th>@lang('Price')</th>
                                    <th>@lang('Size')</th>
                                    <th>@lang('Dimension')</th>
                                     <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>

                            @forelse($products as $prod)
                               
                                <tr>
                                    <td>{{  $loop->iteration }}</td>
                                    <td data-label="@lang('Name')">
                                        {{__ ($prod->name)}}
                                    </td>
                                    <td data-label="@lang('Category Name')">
                                       {{__ ($prod->category->name) }}
                                    </td>
                                     <td data-label="@lang('Short Description')">
                                        {{__ ($prod->short_description)}}
                                                </td>
                                    <td data-label="@lang('Long Description')">
                                        {{__ ($prod->long_description)}}
                                    </td>
                                    <td data-label="@lang('Material Type')">
                                        {{__ ($prod->material_type)}}
                                     </td>
                                      <td data-label="@lang('Status')">
                                        @if($prod->status == 1)
                                            <span class="badge badge--success">@lang('Enable')</span>
                                        @else
                                            <span class="badge badge--danger">@lang('Disabled')</span>
                                        @endif
                                    </td>

                                     <td data-label="@lang('Image')">
                                    <img src="{{ getImage('assets/images/frontend/product/'. $prod->image, '350x260')}}" class="cate-img w-100" alt="product">
                                      </td>

                                 <td data-label="@lang('Price')">
                                        {{__ ($prod->price)}}
                                 </td>

                                <td data-label="@lang('Size')">
                                        {{__ ($prod->size)}}
                                </td>

                                <td data-label="@lang('Dimension')">
                                        {{__ ($prod->dimension)}}
                                                    </td>
                                <td data-label="@lang('Action')">
                                        <a href="{{route('admin.product.edit', $prod->id)}}" class="icon-btn btn--primary">
                                            <i class="las la-edit"></i>
                                        </a>
                              <button class="icon-btn btn--danger removeBtn ml-1" data-id="{{ $prod->id }}"><i class="la la-trash"></i></button>
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
                                    <form action="{{ route('admin.product.remove') }}" method="POST">
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
                                    <td class="text-muted text-center" colspan="100%">{{__($emptyMessage) }}</td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer py-4">
                    {{ paginateLinks($products) }}
                </div>
            </div>
        </div>
    </div>


@endsection

@push('breadcrumb-plugins')


    <a href="{{route('admin.product.create')}}" class="btn btn-md btn--primary box--shadow1 text--small addPlan"><i class="las la-plus"></i>@lang('Add Product')</a>
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