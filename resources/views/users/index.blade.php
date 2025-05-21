@extends('backend.layouts.app')

@section('title')
    {{ $module_title }}
@endsection


@push('after-styles')
    <link rel="stylesheet" href="{{ mix('modules/constant/style.css') }}">
@endpush
@section('content')
    <div class="card">
        <div class="card-body">

            <div class="d-flex justify-content-between flex-wrap gap-3 align-items-center">
                <x-backend.quick-action url="{{ route('backend.users.bulk_action') }}">
                    <div class="">
                        <select name="action_type" class="form-select select2 col-12" id="quick-action-type">
                            <option value="">{{ __('messages.no_action') }}</option>
                            <option value="change-status">{{ __('messages.status') }}</option>
                            <option value="delete">{{ __('messages.delete') }}</option>
                        </select>
                    </div>
                    <div class="select-status d-none quick-action-field" id="change-status-action">
                        <select name="status" class="form-select select2" id="status">
                            <option value="1" selected>{{ __('messages.active') }}</option>
                            <option value="0">{{ __('messages.inactive') }}</option>
                        </select>
                    </div>
                </x-backend.quick-action>
                <x-backend.section-header>
                    <x-slot name="toolbar">
                        <div>
                            <div class="datatable-filter">
                                <select name="column_status" id="column_status" class="select2" data-filter="select">
                                    <option value="">{{ __('messages.all') }}</option>
                                    <option value="0">{{ __('messages.inactive') }}</option>
                                    <option value="1">{{ __('messages.active') }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="input-group flex-nowrap top-input-search">
                            <span class="input-group-text" id="addon-wrapping"><i
                                    class="fa-solid fa-magnifying-glass"></i></span>
                            <input type="text" class="form-control dt-search"
                                placeholder="{{ __('messages.search') }}..." aria-label="Search"
                                aria-describedby="addon-wrapping">
                        </div>
                        @if (userIsSuperAdmin())
                            <a href="{{ route('backend.users.create') }}" class="btn btn-primary" title="Create Vendor">
                                <i class="fas fa-plus-circle"></i>
                                {{ __('frontend.new') }}
                            </a>
                        @endif

                    </x-slot>
                </x-backend.section-header>
            </div>

            <table id="datatable" class="table border table-responsive rounded">
            </table>
        </div>
    </div>

    <div data-render="app">

    </div>
@endsection

@push('after-styles')
    <!-- DataTables Core and Extensions -->
    <link rel="stylesheet" href="{{ asset('vendor/datatable/datatables.min.css') }}">
@endpush

@push('after-scripts')
    <script src="{{ mix('js/vue.min.js') }}"></script>
    <script src="{{ asset('js/form-offcanvas/index.js') }}" defer></script>

    <!-- DataTables Core and Extensions -->
    <script type="text/javascript" src="{{ asset('vendor/datatable/datatables.min.js') }}"></script>

    <script type="text/javascript" defer>
        const columns = [{
                data: 'id',
                name: 'id',
                visible: false
            },
            {
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
                title: '{{ __('users.name') }}'
            },
            {
                data: 'email',
                name: 'email',
                title: '{{ __('users.email') }}'
            },
            {
                data: 'gender',
                name: 'gender',
                title: '{{ __('users.gender') }}'
            },
            {
                data: 'mobile',
                name: 'mobile',
                title: '{{ __('users.mobile') }}'
            },
            {
                data: 'created_at',
                name: 'created_at',
                title: '{{ __('users.created_at') }}'
            },
            {
                data: 'status',
                name: 'status',
                orderable: false,
                searchable: true,
                title: '{{ __('users.status') }}'
            },
        ];


        const actionColumn = [{
            data: 'action',
            name: 'action',
            orderable: false,
            searchable: false,
            title: "{{ __('messages.lbl_action') }}",
            render: function(data, type, row) {
                let buttons = ` <button class="btn btn-primary btn-sm btn-edit" onclick="editUser(${row.id})" title="Edit" data-bs-toggle="tooltip">
                                    <i class="fas fa-edit"></i>
                                </button>
                        <a href="{{ route('backend.users.delete', '') }}/${row.id}"
           id="delete-users-${row.id}"
           class="btn btn-danger btn-sm"
           data-type="ajax"
           data-method="DELETE"
           data-token="{{ csrf_token() }}"
           data-bs-toggle="tooltip"
           title="{{ __('messages.delete') }}"
            data-confirm="{{ __('messages.are_you_sure_user?', ['module' => '${row.name}', 'name' => '']) }}">
            <i class="fa-solid fa-trash"></i>
        </a>
    `;
                return buttons;
            }
        }];

        let finalColumns = [
            ...columns,
            ...actionColumn
        ]

        document.addEventListener('DOMContentLoaded', (event) => {
            const table = initDatatable({
                url: '{{ route("backend.$module_name.index_data") }}',
                finalColumns,
                order: [
                    [0, 'desc']
                ],
                data: {
                    status: $('#filter_status').val(), // Initial value for status filter
                },
            })

            $('#filter_status').change(function() {
                $('#datatable').DataTable().ajax.reload(); // Reload DataTable with new filter value
            });
        })

        function editUser(user_id) {
            var route = "{{ route('backend.users.edit', 'user_id') }}".replace('user_id', user_id);
            window.location.href = route;
        }

        function deleteUser(user_id) {
            var route = "{{ route('backend.users.delete', 'user_id') }}".replace('user_id', user_id);
            confirmDelete(route, user_id);
        }

        function resetQuickAction() {
            const actionValue = $('#quick-action-type').val();
            if (actionValue != '') {
                $('#quick-action-apply').removeAttr('disabled');

                if (actionValue == 'change-status') {
                    $('.quick-action-field').addClass('d-none');
                    $('#change-status-action').removeClass('d-none');
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
    </script>
@endpush
