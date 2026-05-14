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
                            <div class="d-flex align-items-center position-relative my-1">
                                <i class="ki-duotone ki-magnifier fs-1 position-absolute ms-6">
                                    <span class="path1"></span><span class="path2"></span>
                                </i>
                                <input type="text" id="vendor-search" class="form-control form-control-solid w-250px ps-15" placeholder="Search Vendor"/>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-primary" id="btn-create-vendor">
                                    <i class="ki-duotone ki-plus fs-2"></i>
                                    Add Vendor
                                </button>
                            </div>
                        </div>
                        <!--end::Wrapper-->

                        <!--begin::Datatable-->
                        <table id="kt_datatable_vendors" class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                                <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                    <th>Vendor Name</th>
                                    <th>Contact Email</th>
                                    <th>Contact Phone</th>
                                    <th>Address</th>
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

    @include('partials.footer')

    <!--begin::Modal-->
    <div class="modal fade" id="modal-vendor" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-600px">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="fw-bold" id="modal-vendor-title">Add Vendor</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                </div>

                <div class="modal-body px-5 my-7">
                    <form id="form-vendor" class="form">
                        <input type="hidden" id="vendor-id"/>

                        <div class="fv-row mb-7">
                            <label class="required fw-semibold fs-6 mb-2">Vendor Name</label>
                            <input type="text" id="vendor-name" class="form-control form-control-solid" placeholder="Enter vendor name"/>
                            <div class="invalid-feedback" id="vendor-name-error"></div>
                        </div>

                        <div class="row mb-7">
                            <div class="col-md-6 fv-row">
                                <label class="fw-semibold fs-6 mb-2">Contact Email</label>
                                <input type="email" id="vendor-contactEmail" class="form-control form-control-solid" placeholder="email@example.com"/>
                                <div class="invalid-feedback" id="vendor-contactEmail-error"></div>
                            </div>
                            <div class="col-md-6 fv-row">
                                <label class="fw-semibold fs-6 mb-2">Contact Phone</label>
                                <input type="text" id="vendor-contactPhone" class="form-control form-control-solid" placeholder="+62..."/>
                                <div class="invalid-feedback" id="vendor-contactPhone-error"></div>
                            </div>
                        </div>

                        <div class="fv-row mb-7">
                            <label class="fw-semibold fs-6 mb-2">Address</label>
                            <textarea id="vendor-address" class="form-control form-control-solid" rows="3" placeholder="Enter vendor address"></textarea>
                            <div class="invalid-feedback" id="vendor-address-error"></div>
                        </div>

                        <div class="text-center pt-5">
                            <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Discard</button>
                            <button type="submit" class="btn btn-primary" id="btn-submit-vendor">
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

var vendorDt;

var routes = {
    datatable: "{{ route('vendor.datatable') }}",
    store:     "{{ route('vendor.store') }}",
    update:    "{{ url('vendors') }}",
    destroy:   "{{ url('vendors') }}",
    csrf:      "{{ csrf_token() }}"
};

function initVendorDatatable() {
    vendorDt = $('#kt_datatable_vendors').DataTable({
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
                    search: { value: d.search.value, regex: d.search.regex },
                    order: (d.order || []).map(function (o) { return { column: o.column, dir: o.dir }; }),
                    columns: (d.columns || []).map(function (c) { return { data: c.data, name: c.name, searchable: c.searchable, orderable: c.orderable }; })
                });
            },
            dataSrc: function (json) { return json.data || []; }
        },
        columns: [
            { data: 'name',         name: 'name' },
            { data: 'contactEmail', name: 'contactEmail' },
            { data: 'contactPhone', name: 'contactPhone' },
            { data: 'address',      name: 'address' },
            { data: null,           name: 'actions', orderable: false, searchable: false }
        ],
        columnDefs: [
            {
                targets: -1,
                className: 'text-end',
                render: function (data, type, row) {
                    return `
                        <a href="#" class="btn btn-light btn-active-light-primary btn-sm"
                           data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">
                            Actions <i class="ki-duotone ki-down fs-5 ms-1"></i>
                        </a>
                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3 btn-edit-vendor"
                                   data-id="${row.id}"
                                   data-name="${row.name}"
                                   data-contactemail="${row.contactEmail || ''}"
                                   data-contactphone="${row.contactPhone || ''}"
                                   data-address="${row.address || ''}">Edit</a>
                            </div>
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3 text-danger btn-delete-vendor"
                                   data-id="${row.id}" data-name="${row.name}">Delete</a>
                            </div>
                        </div>`;
                }
            }
        ]
    });

    vendorDt.on('draw', function () {
        KTMenu.createInstances();
        bindRowActions();
    });
}

function initSearch() {
    document.getElementById('vendor-search').addEventListener('keyup', function (e) {
        vendorDt.search(e.target.value).draw();
    });
}

document.getElementById('btn-create-vendor').addEventListener('click', function () {
    document.getElementById('modal-vendor-title').textContent = 'Add Vendor';
    document.getElementById('vendor-id').value           = '';
    document.getElementById('vendor-name').value         = '';
    document.getElementById('vendor-contactEmail').value = '';
    document.getElementById('vendor-contactPhone').value = '';
    document.getElementById('vendor-address').value      = '';
    clearErrors();
    new bootstrap.Modal(document.getElementById('modal-vendor')).show();
});

function bindRowActions() {
    document.querySelectorAll('.btn-edit-vendor').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            document.getElementById('modal-vendor-title').textContent   = 'Edit Vendor';
            document.getElementById('vendor-id').value           = this.dataset.id;
            document.getElementById('vendor-name').value         = this.dataset.name;
            document.getElementById('vendor-contactEmail').value = this.dataset.contactemail;
            document.getElementById('vendor-contactPhone').value = this.dataset.contactphone;
            document.getElementById('vendor-address').value      = this.dataset.address;
            clearErrors();
            new bootstrap.Modal(document.getElementById('modal-vendor')).show();
        });
    });

    document.querySelectorAll('.btn-delete-vendor').forEach(function (btn) {
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
                customClass: { confirmButton: 'btn fw-bold btn-danger', cancelButton: 'btn fw-bold btn-active-light-primary' }
            }).then(function (result) {
                if (!result.value) return;
                $.ajax({
                    url: routes.destroy + '/' + id,
                    type: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': routes.csrf, 'Accept': 'application/json' },
                    success: function (res) {
                        Swal.fire({
                            text: res.message || 'Vendor deleted.',
                            icon: 'success',
                            buttonsStyling: false,
                            confirmButtonText: 'Ok, got it!',
                            customClass: { confirmButton: 'btn fw-bold btn-primary' }
                        }).then(function () { vendorDt.draw(); });
                    },
                    error: function (xhr) {
                        var msg = xhr.responseJSON ? xhr.responseJSON.message : 'Something went wrong.';
                        Swal.fire({ text: msg, icon: 'error', buttonsStyling: false, confirmButtonText: 'Ok, got it!', customClass: { confirmButton: 'btn fw-bold btn-primary' } });
                    }
                });
            });
        });
    });
}

document.getElementById('form-vendor').addEventListener('submit', function (e) {
    e.preventDefault();

    var id    = document.getElementById('vendor-id').value.trim();
    var name  = document.getElementById('vendor-name').value.trim();

    if (!name) { showFieldError('vendor-name', 'vendor-name-error', 'Vendor name is required.'); return; }
    clearErrors();

    var $btn = document.getElementById('btn-submit-vendor');
    $btn.setAttribute('data-kt-indicator', 'on');
    $btn.disabled = true;

    var isEdit = id !== '';
    var url    = isEdit ? routes.update + '/' + id : routes.store;
    var method = isEdit ? 'PUT' : 'POST';

    var payload = {
        name:         document.getElementById('vendor-name').value.trim(),
        contactEmail: document.getElementById('vendor-contactEmail').value.trim(),
        contactPhone: document.getElementById('vendor-contactPhone').value.trim(),
        address:      document.getElementById('vendor-address').value.trim(),
    };

    $.ajax({
        url: url, type: method,
        headers: { 'X-CSRF-TOKEN': routes.csrf, 'Accept': 'application/json', 'Content-Type': 'application/json' },
        data: JSON.stringify(payload),
        success: function (res) {
            $btn.removeAttribute('data-kt-indicator');
            $btn.disabled = false;
            bootstrap.Modal.getInstance(document.getElementById('modal-vendor')).hide();
            Swal.fire({
                text: res.message || 'Vendor saved.',
                icon: 'success',
                buttonsStyling: false,
                confirmButtonText: 'Ok, got it!',
                customClass: { confirmButton: 'btn fw-bold btn-primary' }
            }).then(function () { vendorDt.draw(); });
        },
        error: function (xhr) {
            $btn.removeAttribute('data-kt-indicator');
            $btn.disabled = false;
            var res = xhr.responseJSON || {};
            if (res.errors) {
                Object.keys(res.errors).forEach(function (field) {
                    showFieldError('vendor-' + field, 'vendor-' + field + '-error', res.errors[field][0]);
                });
            } else {
                Swal.fire({ text: res.message || 'Something went wrong.', icon: 'error', buttonsStyling: false, confirmButtonText: 'Ok, got it!', customClass: { confirmButton: 'btn fw-bold btn-primary' } });
            }
        }
    });
});

function showFieldError(inputId, errorId, msg) {
    document.getElementById(inputId).classList.add('is-invalid');
    document.getElementById(errorId).textContent = msg;
}

function clearErrors() {
    ['vendor-name', 'vendor-contactEmail', 'vendor-contactPhone', 'vendor-address'].forEach(function (id) {
        document.getElementById(id).classList.remove('is-invalid');
    });
    ['vendor-name-error', 'vendor-contactEmail-error', 'vendor-contactPhone-error', 'vendor-address-error'].forEach(function (id) {
        document.getElementById(id).textContent = '';
    });
}

KTUtil.onDOMContentLoaded(function () {
    initVendorDatatable();
    initSearch();
});
</script>
@endpush
