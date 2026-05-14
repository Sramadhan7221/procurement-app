@extends('layouts.app')

@section('title', $title)

@section('content')
    <!--begin::Content wrapper-->
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">{{ $title }}</h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('home') }}" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">{{ $title }}</li>
                    </ul>
                </div>
            </div>
        </div>
        <!--end::Toolbar-->

        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-fluid">
                <div class="row g-5 gx-xl-10 mb-5 mb-xl-10">
                    <div class="col-12">
                        <!--begin::Wrapper-->
                        <div class="d-flex flex-stack mb-5">
                            <!--begin::Search-->
                            <div class="d-flex align-items-center position-relative my-1">
                                <i class="ki-duotone ki-magnifier fs-1 position-absolute ms-6">
                                    <span class="path1"></span><span class="path2"></span>
                                </i>
                                <input type="text" id="division-search" class="form-control form-control-solid w-250px ps-15" placeholder="Search Division"/>
                            </div>
                            <!--end::Search-->

                            <!--begin::Add button-->
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-primary" id="btn-create-division">
                                    <i class="ki-duotone ki-plus fs-2"></i>
                                    Add Division
                                </button>
                            </div>
                            <!--end::Add button-->
                        </div>
                        <!--end::Wrapper-->

                        <!--begin::Datatable-->
                        <table id="kt_datatable_divisions" class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                                <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                    <th>Division Name</th>
                                    <th class="text-end min-w-100px">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 fw-semibold"></tbody>
                        </table>
                        <!--end::Datatable-->
                    </div>
                </div>
            </div>
        </div>
        <!--end::Content-->
    </div>
    <!--end::Content wrapper-->

    <!--begin::Footer-->
    @include('partials.footer')
    <!--end::Footer-->

    <!--begin::Modal-->
    <div class="modal fade" id="modal-division" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-500px">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="fw-bold" id="modal-division-title">Add Division</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                </div>

                <div class="modal-body px-5 my-7">
                    <form id="form-division" class="form">
                        <input type="hidden" id="division-id"/>
                        <div class="fv-row mb-7">
                            <label class="required fw-semibold fs-6 mb-2">Division Name</label>
                            <input type="text" id="division-name" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Enter division name"/>
                            <div class="invalid-feedback" id="division-name-error"></div>
                        </div>
                        <div class="text-center pt-5">
                            <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Discard</button>
                            <button type="submit" class="btn btn-primary" id="btn-submit-division">
                                <span class="indicator-label">Submit</span>
                                <span class="indicator-progress">
                                    Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--end::Modal-->
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script>
"use strict";

var divisionDt;

var routes = {
    datatable: "{{ route('division.datatable') }}",
    store:     "{{ route('division.store') }}",
    update:    "{{ url('divisions') }}",
    destroy:   "{{ url('divisions') }}",
    csrf:      "{{ csrf_token() }}"
};

// Init DataTable
function initDivisionDatatable() {
    divisionDt = $('#kt_datatable_divisions').DataTable({
        searchDelay: 500,
        processing: true,
        serverSide: true,
        ordering: true,
        order: [[0, 'asc']],
        ajax: {
            url: routes.datatable,
            type: 'POST',
            headers: { 'X-CSRF-TOKEN': routes.csrf },
            contentType: 'application/json',
            data: function (d) {
                return JSON.stringify({
                    draw:    d.draw,
                    start:   d.start,
                    length:  d.length,
                    search: {
                        value: d.search.value,
                        regex: d.search.regex
                    },
                    order: (d.order || []).map(function (o) {
                        return { column: o.column, dir: o.dir };
                    }),
                    columns: (d.columns || []).map(function (c) {
                        return {
                            data:       c.data,
                            name:       c.name,
                            searchable: c.searchable,
                            orderable:  c.orderable
                        };
                    })
                });
            },
            dataSrc: function (json) {
                return json.data || [];
            }
        },
        columns: [
            { data: 'name', name: 'name' },
            { data: null,   name: 'actions', orderable: false, searchable: false }
        ],
        columnDefs: [
            {
                targets: -1,
                className: 'text-end',
                render: function (data, type, row) {
                    return `
                        <a href="#" class="btn btn-light btn-active-light-primary btn-sm"
                           data-kt-menu-trigger="click"
                           data-kt-menu-placement="bottom-end"
                           data-kt-menu-flip="top-end">
                            Actions
                            <i class="ki-duotone ki-down fs-5 ms-1"></i>
                        </a>
                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3 btn-edit-division"
                                   data-id="${row.id}"
                                   data-name="${row.name}">
                                    Edit
                                </a>
                            </div>
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3 text-danger btn-delete-division"
                                   data-id="${row.id}"
                                   data-name="${row.name}">
                                    Delete
                                </a>
                            </div>
                        </div>`;
                }
            }
        ]
    });

    divisionDt.on('draw', function () {
        KTMenu.createInstances();
        bindRowActions();
    });
}

// Search
function initSearch() {
    document.getElementById('division-search').addEventListener('keyup', function (e) {
        divisionDt.search(e.target.value).draw();
    });
}

// Open modal for create
document.getElementById('btn-create-division').addEventListener('click', function () {
    document.getElementById('modal-division-title').textContent = 'Add Division';
    document.getElementById('division-id').value   = '';
    document.getElementById('division-name').value = '';
    clearNameError();
    new bootstrap.Modal(document.getElementById('modal-division')).show();
});

// Bind edit/delete on each draw
function bindRowActions() {
    // Edit
    document.querySelectorAll('.btn-edit-division').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            document.getElementById('modal-division-title').textContent = 'Edit Division';
            document.getElementById('division-id').value   = this.dataset.id;
            document.getElementById('division-name').value = this.dataset.name;
            clearNameError();
            new bootstrap.Modal(document.getElementById('modal-division')).show();
        });
    });

    // Delete
    document.querySelectorAll('.btn-delete-division').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            var id   = this.dataset.id;
            var name = this.dataset.name;

            Swal.fire({
                text: 'Are you sure you want to delete "' + name + '"?',
                icon: 'warning',
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: 'Yes, delete!',
                cancelButtonText: 'No, cancel',
                customClass: {
                    confirmButton: 'btn fw-bold btn-danger',
                    cancelButton: 'btn fw-bold btn-active-light-primary'
                }
            }).then(function (result) {
                if (!result.value) return;

                $.ajax({
                    url: routes.destroy + '/' + id,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': routes.csrf,
                        'Accept': 'application/json'
                    },
                    success: function (res) {
                        Swal.fire({
                            text: res.message || 'Division deleted.',
                            icon: 'success',
                            buttonsStyling: false,
                            confirmButtonText: 'Ok, got it!',
                            customClass: { confirmButton: 'btn fw-bold btn-primary' }
                        }).then(function () { divisionDt.draw(); });
                    },
                    error: function (xhr) {
                        var msg = xhr.responseJSON ? xhr.responseJSON.message : 'Something went wrong.';
                        Swal.fire({
                            text: msg,
                            icon: 'error',
                            buttonsStyling: false,
                            confirmButtonText: 'Ok, got it!',
                            customClass: { confirmButton: 'btn fw-bold btn-primary' }
                        });
                    }
                });
            });
        });
    });
}

// Form submit (create / update)
document.getElementById('form-division').addEventListener('submit', function (e) {
    e.preventDefault();

    var id   = document.getElementById('division-id').value.trim();
    var name = document.getElementById('division-name').value.trim();

    if (!name) {
        showNameError('Division name is required.');
        return;
    }
    clearNameError();

    var $btn = document.getElementById('btn-submit-division');
    $btn.setAttribute('data-kt-indicator', 'on');
    $btn.disabled = true;

    var isEdit = id !== '';
    var url    = isEdit ? routes.update + '/' + id : routes.store;
    var method = isEdit ? 'PUT' : 'POST';

    $.ajax({
        url:  url,
        type: method,
        headers: {
            'X-CSRF-TOKEN': routes.csrf,
            'Accept':       'application/json',
            'Content-Type': 'application/json'
        },
        data: JSON.stringify({ name: name }),
        success: function (res) {
            $btn.removeAttribute('data-kt-indicator');
            $btn.disabled = false;

            bootstrap.Modal.getInstance(document.getElementById('modal-division')).hide();

            Swal.fire({
                text: res.message || 'Division saved.',
                icon: 'success',
                buttonsStyling: false,
                confirmButtonText: 'Ok, got it!',
                customClass: { confirmButton: 'btn fw-bold btn-primary' }
            }).then(function () { divisionDt.draw(); });
        },
        error: function (xhr) {
            $btn.removeAttribute('data-kt-indicator');
            $btn.disabled = false;

            var res = xhr.responseJSON || {};
            if (res.errors && res.errors.name) {
                showNameError(res.errors.name[0]);
            } else {
                Swal.fire({
                    text: res.message || 'Something went wrong.',
                    icon: 'error',
                    buttonsStyling: false,
                    confirmButtonText: 'Ok, got it!',
                    customClass: { confirmButton: 'btn fw-bold btn-primary' }
                });
            }
        }
    });
});

function showNameError(msg) {
    var input = document.getElementById('division-name');
    var err   = document.getElementById('division-name-error');
    input.classList.add('is-invalid');
    err.textContent = msg;
}

function clearNameError() {
    var input = document.getElementById('division-name');
    var err   = document.getElementById('division-name-error');
    input.classList.remove('is-invalid');
    err.textContent = '';
}

// Boot
KTUtil.onDOMContentLoaded(function () {
    initDivisionDatatable();
    initSearch();
});
</script>
@endpush
