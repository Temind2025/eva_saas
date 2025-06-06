@extends('backend.layouts.app')

@section('title')
    {{ __($module_title) }}
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <x-backend.section-header>
                <div class="d-flex flex-wrap gap-3">
                    @if (auth()->user()->can('edit_branch') || auth()->user()->can('delete_branch'))
                        <x-backend.quick-action url="{{ route('backend.promotions.bulk_action') }}">
                            <div class="">
                                <select name="action_type" class="form-control select2 col-12" id="quick-action-type"
                                    style="width:100%">
                                    <option value="">{{ __('messages.no_action') }}</option>
                                    @hasPermission('edit_promotion')
                                        <option value="change-status">{{ __('messages.status') }}</option>
                                    @endhasPermission
                                    @hasPermission('delete_promotion')
                                        <option value="delete">{{ __('messages.delete') }}</option>
                                    @endhasPermission
                                </select>
                            </div>
                            <div class="select-status d-none quick-action-field" id="change-status-action">
                                <select name="status" class="form-control search-hide select2" id="status"
                                    style="width:100%">
                                    <option value="1" selected>{{ __('messages.active') }}</option>
                                    <option value="0">{{ __('messages.inactive') }}</option>
                                </select>
                            </div>
                        </x-backend.quick-action>
                    @endif

                </div>
                <x-slot name="toolbar">

                    <div>
                        <div class="datatable-filter">
                            <select name="column_status" id="column_status" class="select2  form-control"
                                data-filter="select" style="width: 100%">
                                <option value="">{{ __('messages.all') }}</option>
                                <option value="0" {{ $filter['status'] == '0' ? 'selected' : '' }}>
                                    {{ __('messages.inactive') }}</option>
                                <option value="1" {{ $filter['status'] == '1' ? 'selected' : '' }}>
                                    {{ __('messages.active') }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="input-group flex-nowrap top-input-search">
                        <span class="input-group-text" id="addon-wrapping"><i
                                class="fa-solid fa-magnifying-glass"></i></span>
                        <input type="text" class="form-control dt-search" placeholder="{{ __('messages.search') }}..." aria-label="Search"
                            aria-describedby="addon-wrapping">
                    </div>
                    @hasPermission('add_promotion')
                        <x-buttons.offcanvas target='#form-offcanvas'
                            title="">
                            {{ __('messages.new') }}</x-buttons.offcanvas>
                    @endhasPermission
                </x-slot>
            </x-backend.section-header>
            <table id="datatable" class="table table-striped border table-responsive">
            </table>
        </div>
    </div>
    <div data-render="app">
        <form-offcanvas default-image="{{promotion_image()}}" create-title="{{ __('messages.new') }} {{ __('promotion.singular_title') }}"
            edit-title="{{ __('messages.edit') }} {{ __('promotion.singular_title') }}"
            :customefield="{{ json_encode($customefield) }}">
        </form-offcanvas>
    </div>
    <x-backend.advance-filter>
        <x-slot name="title">
            <h4>{{ __('service.lbl_advanced_filter') }}</h4>
        </x-slot>
        <button type="reset" class="btn btn-danger" id="reset-filter">{{ __('messages.reset') }}</button>
    </x-backend.advance-filter>
@endsection

@push('after-styles')
    <link rel="stylesheet" href="{{ mix('modules/promotion/style.css') }}">

    <!-- DataTables Core and Extensions -->
    <link rel="stylesheet" href="{{ asset('vendor/datatable/datatables.min.css') }}">
@endpush

@push('after-scripts')
    <script src="{{ mix('modules/promotion/script.js') }}"></script>
    <script src="{{ asset('js/form-offcanvas/index.js') }}" defer></script>
    <script src="{{ asset('js/form-modal/index.js') }}" defer></script>

    <!-- DataTables Core and Extensions -->
    <script type="text/javascript" src="{{ asset('vendor/datatable/datatables.min.js') }}"></script>

    <script type="text/javascript" defer>
        const columns = [{
                data: 'id',
                name: 'id',
                title: "{{__('messages.id')}}",
                orderable: true,
                visible: false,
            }, {
                name: 'check',
                data: 'check',
                title: '<input type="checkbox" class="form-check-input" name="select_all_table" id="select-all-table" onclick="selectAllTable(this)">',
                width: '0%',
                exportable: false,
                orderable: false,
                searchable: false,
            },
            {
                data: 'name',
                name: 'name',
                title: "{{ __('promotion.lbl_name') }}"
            },
            {
                data: 'description',
                name: 'description',
                title: "{{ __('promotion.description') }}"

            },
            {
                data: 'coupon_type',
                name: 'coupon_type',
                title: "{{ __('promotion.coupon_type') }}",
                searchable: false

            },
            {
                data: 'coupon_price',
                name: 'coupon_price',
                title: "{{ __('promotion.coupon_price') }}",
                searchable: false

            },

            {
                data: 'start_date_time',
                name: 'start_date_time',
                title: "{{ __('promotion.start_datetime') }}"
            },
            {
                data: 'end_date_time',
                name: 'end_date_time',
                title: "{{ __('promotion.end_datetime') }}"
            },
            {
                data: 'is_expired',
                name: 'is_expired',
                orderable: true,
                searchable: true,
                title: "{{ __('promotion.lbl_expired') }}",
                width: '5%',

            },
            {
                data: 'status',
                name: 'status',
                orderable: true,
                searchable: true,
                title: "{{ __('promotion.lbl_status') }}",
                width: '5%'
            },

            {
                data: 'updated_at',
                name: 'updated_at',
                title: "{{ __('promotion.lbl_update_at') }}",
                orderable: true,
                visible: false,
            },

        ]


        const actionColumn = [{
            data: 'action',
            name: 'action',
            orderable: false,
            searchable: false,
            title: "{{ __('promotion.lbl_action') }}",
            width: '5%'
        }]

        const customFieldColumns = JSON.parse(@json($columns))

        let finalColumns = [
            ...columns,
            ...customFieldColumns,
            ...actionColumn
        ]
        const userRole = "{{ $userRole }}";
        const couponTypeColumnIndex = finalColumns.findIndex(col => col.name === 'coupon_type');

    if (userRole === 'super admin' && couponTypeColumnIndex !== -1) {
        finalColumns.splice(couponTypeColumnIndex, 1);
    }

        document.addEventListener('DOMContentLoaded', (event) => {

            initDatatable({
                url: '{{ route("backend.$module_name.index_data") }}',
                finalColumns,
                orderColumn: [
            [finalColumns.length - 1, "desc"]
        ],
                advanceFilter: () => {
                    return {}
                }
            });
        })

        function resetQuickAction() {
            const actionValue = $('#quick-action-type').val();
            if (actionValue != '') {
                $('#quick-action-apply').removeAttr('disabled');

                if (actionValue == 'change-status') {
                    $('.quick-action-field').addClass('d-none');
                    $('#change-status-action').removeClass('d-none');
                    $('#status').val('1').trigger('change');
                    $('.search-hide').select2({
                        minimumResultsForSearch: -1 // Hides the search box
                    });
                } else {
                    $('.quick-action-field').addClass('d-none');
                }
            } else {
                $('#quick-action-apply').attr('disabled', true);
                $('.quick-action-field').addClass('d-none');
            }
        }

        $('#quick-action-type').change(function() {
            resetQuickAction()
        });
        $(document).on('click', '[data-bs-toggle="tooltip"]', function () {
        $(this).tooltip('dispose');
        $('.tooltip').remove();
});
    </script>
@endpush
