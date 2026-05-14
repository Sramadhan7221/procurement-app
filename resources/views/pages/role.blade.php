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
                        <div class="d-flex flex-stack mb-5">
                            <div class="d-flex align-items-center position-relative my-1">
                                <i class="ki-duotone ki-magnifier fs-1 position-absolute ms-6">
                                    <span class="path1"></span><span class="path2"></span>
                                </i>
                                <input type="text" id="role-search" class="form-control form-control-solid w-250px ps-15" placeholder="Search Role"/>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-primary" id="btn-create-role">
                                    <i class="ki-duotone ki-plus fs-2"></i>
                                    Add Role
                                </button>
                            </div>
                        </div>

                        <!--begin::Datatable-->
                        <table id="kt_datatable_roles" class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                                <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                    <th>Role Name</th>
                                    <th>Assigned Menus</th>
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
    <div class="modal fade" id="modal-role" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-700px">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="fw-bold" id="modal-role-title">Add Role</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                </div>

                <div class="modal-body px-5 my-5">
                    <form id="form-role" class="form">
                        <input type="hidden" id="role-id"/>

                        <!--begin::Role name-->
                        <div class="fv-row mb-7">
                            <label class="required fw-semibold fs-6 mb-2">Role Name</label>
                            <input type="text" id="role-name" class="form-control form-control-solid" placeholder="Enter role name"/>
                            <div class="invalid-feedback" id="role-name-error"></div>
                        </div>
                        <!--end::Role name-->

                        <div class="separator separator-dashed my-5"></div>

                        <!--begin::Menu assignment panel-->
                        <div class="mb-5">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <span class="fw-bold text-gray-700 fs-6 text-uppercase">Menu Permissions</span>
                                <span class="badge badge-light-primary" id="menu-loading-badge" style="display:none;">
                                    <span class="spinner-border spinner-border-sm me-1"></span> Loading...
                                </span>
                            </div>

                            @php
                                $groups = collect($availableMenus)->groupBy('group');
                            @endphp

                            @foreach ($groups as $groupName => $menus)
                                <div class="mb-4">
                                    <div class="text-muted fw-semibold fs-7 text-uppercase mb-2">{{ $groupName }}</div>
                                    <div class="row g-3">
                                        @foreach ($menus as $menu)
                                            <div class="col-md-4">
                                                <label class="d-flex align-items-center gap-2 cursor-pointer p-3 border border-dashed rounded menu-permission-item"
                                                       data-menu-id="{{ $menu['id'] }}">
                                                    <input type="checkbox"
                                                           class="form-check-input menu-checkbox"
                                                           value="{{ $menu['id'] }}"
                                                           id="menu-{{ $menu['id'] }}"
                                                           style="width:18px;height:18px;"/>
                                                    <span class="fw-semibold fs-6 text-gray-700">{{ $menu['name'] }}</span>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach

                            <div id="menu-status-msg" class="mt-2 fs-7"></div>
                        </div>
                        <!--end::Menu assignment panel-->

                        <div class="text-center pt-5">
                            <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Discard</button>
                            <button type="submit" class="btn btn-primary" id="btn-submit-role">
                                <span class="indicator-label">Save Role</span>
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
<style>
    .menu-permission-item { transition: background-color 0.15s; }
    .menu-permission-item:has(.menu-checkbox:checked) {
        background-color: #f1faff;
        border-color: #009ef7 !important;
    }
    .menu-permission-item.menu-saving { opacity: 0.6; pointer-events: none; }
</style>
@endpush

@push('scripts')
<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script>
"use strict";

var roleDt;
var currentRoleId      = null;
var originalMenuIds    = [];

var routes = {
    datatable:  "{{ route('role.datatable') }}",
    store:      "{{ route('role.store') }}",
    update:     "{{ url('roles') }}",
    destroy:    "{{ url('roles') }}",
    menusBase:  "{{ url('roles') }}",
    csrf:       "{{ csrf_token() }}"
};

// ── DataTable ─────────────────────────────────────────────────────────────────

function initRoleDatatable() {
    roleDt = $('#kt_datatable_roles').DataTable({
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
            { data: 'name',  name: 'name' },
            { data: 'menus', name: 'menus', orderable: false, searchable: false },
            { data: null,    name: 'actions', orderable: false, searchable: false }
        ],
        columnDefs: [
            {
                targets: 1,
                render: function (data) {
                    if (!data || !data.length) return '<span class="text-muted">—</span>';
                    var tags = (Array.isArray(data) ? data : []).map(function (m) {
                        var label = m.name || m.menuId || m;
                        return '<span class="badge badge-light-primary me-1">' + label + '</span>';
                    }).join('');
                    return tags || '<span class="text-muted">—</span>';
                }
            },
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
                                <a href="#" class="menu-link px-3 btn-edit-role"
                                   data-id="${row.id}" data-name="${row.name}">Edit</a>
                            </div>
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3 text-danger btn-delete-role"
                                   data-id="${row.id}" data-name="${row.name}">Delete</a>
                            </div>
                        </div>`;
                }
            }
        ]
    });

    roleDt.on('draw', function () {
        KTMenu.createInstances();
        bindRowActions();
    });
}

function initSearch() {
    document.getElementById('role-search').addEventListener('keyup', function (e) {
        roleDt.search(e.target.value).draw();
    });
}

// ── Menu checkboxes ───────────────────────────────────────────────────────────

function uncheckAllMenus() {
    document.querySelectorAll('.menu-checkbox').forEach(function (cb) { cb.checked = false; });
}

function loadRoleMenus(roleId) {
    document.getElementById('menu-loading-badge').style.display = '';
    document.getElementById('menu-status-msg').textContent = '';

    $.ajax({
        url: routes.menusBase + '/' + roleId + '/menus',
        type: 'GET',
        headers: { 'X-CSRF-TOKEN': routes.csrf, 'Accept': 'application/json' },
        success: function (res) {
            document.getElementById('menu-loading-badge').style.display = 'none';
            var assigned = res.data || [];
            originalMenuIds = assigned.map(function (m) { return m.menuId || m.id || m; });
            uncheckAllMenus();
            originalMenuIds.forEach(function (menuId) {
                var cb = document.getElementById('menu-' + menuId);
                if (cb) cb.checked = true;
            });
        },
        error: function () {
            document.getElementById('menu-loading-badge').style.display = 'none';
            document.getElementById('menu-status-msg').textContent = 'Failed to load current menus.';
        }
    });
}

// ── Modal open ────────────────────────────────────────────────────────────────

function openModal(title, id, name) {
    document.getElementById('modal-role-title').textContent = title;
    document.getElementById('role-id').value   = id || '';
    document.getElementById('role-name').value = name || '';
    document.getElementById('role-name-error').textContent = '';
    document.getElementById('role-name').classList.remove('is-invalid');
    document.getElementById('menu-status-msg').textContent = '';

    currentRoleId = id || null;
    uncheckAllMenus();
    originalMenuIds = [];

    if (id) {
        loadRoleMenus(id);
    } else {
        document.getElementById('menu-loading-badge').style.display = 'none';
    }

    new bootstrap.Modal(document.getElementById('modal-role')).show();
}

document.getElementById('btn-create-role').addEventListener('click', function () {
    openModal('Add Role', null, null);
});

// ── Row actions ───────────────────────────────────────────────────────────────

function bindRowActions() {
    document.querySelectorAll('.btn-edit-role').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            openModal('Edit Role', this.dataset.id, this.dataset.name);
        });
    });

    document.querySelectorAll('.btn-delete-role').forEach(function (btn) {
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
                            text: res.message || 'Role deleted.',
                            icon: 'success',
                            buttonsStyling: false,
                            confirmButtonText: 'Ok, got it!',
                            customClass: { confirmButton: 'btn fw-bold btn-primary' }
                        }).then(function () { roleDt.draw(); });
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

// ── Menu diff helpers ─────────────────────────────────────────────────────────

function getCheckedMenuIds() {
    return Array.from(document.querySelectorAll('.menu-checkbox:checked')).map(function (cb) { return cb.value; });
}

function syncMenus(roleId, callback) {
    var currentIds = getCheckedMenuIds();
    var toAdd      = currentIds.filter(function (id) { return !originalMenuIds.includes(id); });
    var toRemove   = originalMenuIds.filter(function (id) { return !currentIds.includes(id); });

    var statusEl = document.getElementById('menu-status-msg');
    statusEl.textContent = '';

    var promises = [];

    if (toAdd.length) {
        promises.push(new Promise(function (resolve, reject) {
            $.ajax({
                url: routes.menusBase + '/' + roleId + '/menus',
                type: 'POST',
                headers: { 'X-CSRF-TOKEN': routes.csrf, 'Accept': 'application/json', 'Content-Type': 'application/json' },
                data: JSON.stringify({ menuIds: toAdd }),
                success: resolve,
                error: reject
            });
        }));
    }

    toRemove.forEach(function (menuId) {
        promises.push(new Promise(function (resolve, reject) {
            $.ajax({
                url: routes.menusBase + '/' + roleId + '/menus/' + menuId,
                type: 'DELETE',
                headers: { 'X-CSRF-TOKEN': routes.csrf, 'Accept': 'application/json' },
                success: resolve,
                error: reject
            });
        }));
    });

    if (!promises.length) {
        callback(true);
        return;
    }

    Promise.all(promises)
        .then(function () { callback(true); })
        .catch(function () {
            statusEl.textContent = 'Some menu changes could not be saved.';
            statusEl.className = 'mt-2 fs-7 text-danger';
            callback(false);
        });
}

// ── Form submit ───────────────────────────────────────────────────────────────

document.getElementById('form-role').addEventListener('submit', function (e) {
    e.preventDefault();

    var id   = document.getElementById('role-id').value.trim();
    var name = document.getElementById('role-name').value.trim();

    if (!name) {
        document.getElementById('role-name').classList.add('is-invalid');
        document.getElementById('role-name-error').textContent = 'Role name is required.';
        return;
    }
    document.getElementById('role-name').classList.remove('is-invalid');
    document.getElementById('role-name-error').textContent = '';

    var $btn  = document.getElementById('btn-submit-role');
    $btn.setAttribute('data-kt-indicator', 'on');
    $btn.disabled = true;

    var isEdit = id !== '';
    var url    = isEdit ? routes.update + '/' + id : routes.store;
    var method = isEdit ? 'PUT' : 'POST';

    $.ajax({
        url: url, type: method,
        headers: { 'X-CSRF-TOKEN': routes.csrf, 'Accept': 'application/json', 'Content-Type': 'application/json' },
        data: JSON.stringify({ name: name }),
        success: function (res) {
            var savedRoleId = (res.data && res.data.id) ? res.data.id : id;

            syncMenus(savedRoleId, function (menusSynced) {
                $btn.removeAttribute('data-kt-indicator');
                $btn.disabled = false;

                bootstrap.Modal.getInstance(document.getElementById('modal-role')).hide();

                Swal.fire({
                    text: res.message || 'Role saved.',
                    icon: menusSynced ? 'success' : 'warning',
                    buttonsStyling: false,
                    confirmButtonText: 'Ok, got it!',
                    customClass: { confirmButton: 'btn fw-bold btn-primary' }
                }).then(function () { roleDt.draw(); });
            });
        },
        error: function (xhr) {
            $btn.removeAttribute('data-kt-indicator');
            $btn.disabled = false;
            var res = xhr.responseJSON || {};
            if (res.errors && res.errors.name) {
                document.getElementById('role-name').classList.add('is-invalid');
                document.getElementById('role-name-error').textContent = res.errors.name[0];
            } else {
                Swal.fire({ text: res.message || 'Something went wrong.', icon: 'error', buttonsStyling: false, confirmButtonText: 'Ok, got it!', customClass: { confirmButton: 'btn fw-bold btn-primary' } });
            }
        }
    });
});

// ── Boot ──────────────────────────────────────────────────────────────────────

KTUtil.onDOMContentLoaded(function () {
    initRoleDatatable();
    initSearch();
});
</script>
@endpush
