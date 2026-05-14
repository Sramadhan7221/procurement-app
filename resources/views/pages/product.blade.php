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
                                <input type="text" id="product-search" class="form-control form-control-solid w-250px ps-15" placeholder="Search Product"/>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-primary" id="btn-create-product">
                                    <i class="ki-duotone ki-plus fs-2"></i>
                                    Add Product
                                </button>
                            </div>
                        </div>

                        <!--begin::Datatable-->
                        <table id="kt_datatable_products" class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                                <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>SKU</th>
                                    <th>Category</th>
                                    <th>Vendor</th>
                                    <th>Base Price</th>
                                    <th>UoM</th>
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
    <div class="modal fade" id="modal-product" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="fw-bold" id="modal-product-title">Add Product</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                </div>

                <div class="modal-body px-5 my-5">
                    <form id="form-product" class="form" enctype="multipart/form-data">
                        <input type="hidden" id="product-id"/>

                        <div class="row g-5">
                            <!--begin::Left column (relational + image)-->
                            <div class="col-lg-4">
                                <!--begin::Image upload-->
                                <div class="fv-row mb-7 text-center">
                                    <label class="fw-semibold fs-6 mb-3 d-block">Product Image</label>
                                    <div class="image-input image-input-outline d-inline-block" id="product-image-wrapper">
                                        <div class="image-input-wrapper w-150px h-150px" id="product-image-preview"
                                             style="background-image: url('{{ asset('assets/media/svg/avatars/blank.svg') }}'); background-size: cover; background-position: center;">
                                        </div>
                                        <label class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                               data-kt-image-input-action="change" title="Change image">
                                            <i class="ki-duotone ki-pencil fs-6"><span class="path1"></span><span class="path2"></span></i>
                                            <input type="file" id="product-image-input" name="ProductImage" accept=".png,.jpg,.jpeg,.gif,.webp"/>
                                        </label>
                                        <span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                              id="btn-remove-image" title="Remove image" style="display:none;">
                                            <i class="ki-duotone ki-cross fs-2"><span class="path1"></span><span class="path2"></span></i>
                                        </span>
                                    </div>
                                    <div class="text-muted fs-7 mt-2">Allowed: png, jpg, jpeg, gif, webp</div>
                                </div>
                                <!--end::Image upload-->

                                <!--begin::Category-->
                                <div class="fv-row mb-7">
                                    <label class="required fw-semibold fs-6 mb-2">Category</label>
                                    <select id="product-categoryId" class="form-select form-select-solid">
                                        <option value="">Select category...</option>
                                    </select>
                                    <div class="invalid-feedback" id="product-categoryId-error"></div>
                                </div>
                                <!--end::Category-->

                                <!--begin::Vendor-->
                                <div class="fv-row mb-7">
                                    <label class="required fw-semibold fs-6 mb-2">Vendor</label>
                                    <select id="product-vendorId" class="form-select form-select-solid">
                                        <option value="">Select vendor...</option>
                                    </select>
                                    <div class="invalid-feedback" id="product-vendorId-error"></div>
                                </div>
                                <!--end::Vendor-->
                            </div>
                            <!--end::Left column-->

                            <!--begin::Right column (product details)-->
                            <div class="col-lg-8">
                                <!--begin::Name-->
                                <div class="fv-row mb-7">
                                    <label class="required fw-semibold fs-6 mb-2">Product Name</label>
                                    <input type="text" id="product-name" class="form-control form-control-solid" placeholder="Enter product name"/>
                                    <div class="invalid-feedback" id="product-name-error"></div>
                                </div>
                                <!--end::Name-->

                                <!--begin::Product details section-->
                                <div class="separator separator-dashed my-5"></div>
                                <div class="fw-bold text-gray-600 fs-7 text-uppercase mb-4">Product Details</div>

                                <div class="row mb-7">
                                    <div class="col-md-6 fv-row">
                                        <label class="required fw-semibold fs-6 mb-2">SKU</label>
                                        <input type="text" id="product-sku" class="form-control form-control-solid" placeholder="e.g. PRD-001"/>
                                        <div class="invalid-feedback" id="product-sku-error"></div>
                                    </div>
                                    <div class="col-md-6 fv-row">
                                        <label class="required fw-semibold fs-6 mb-2">Unit of Measure (UoM)</label>
                                        <input type="text" id="product-uom" class="form-control form-control-solid" placeholder="e.g. pcs, kg, box"/>
                                        <div class="invalid-feedback" id="product-uom-error"></div>
                                    </div>
                                </div>

                                <div class="fv-row mb-7">
                                    <label class="required fw-semibold fs-6 mb-2">Base Price</label>
                                    <div class="input-group">
                                        <span class="input-group-text border-0 bg-light-secondary fw-semibold">Rp</span>
                                        <input type="number" id="product-basePrice" class="form-control form-control-solid" placeholder="0.00" min="0" step="0.01"/>
                                    </div>
                                    <div class="invalid-feedback d-block" id="product-basePrice-error"></div>
                                </div>

                                <div class="fv-row mb-7">
                                    <label class="fw-semibold fs-6 mb-2">Detail / Description</label>
                                    <textarea id="product-detail" class="form-control form-control-solid" rows="4" placeholder="Enter product details or description"></textarea>
                                    <div class="invalid-feedback" id="product-detail-error"></div>
                                </div>
                                <!--end::Product details section-->
                            </div>
                            <!--end::Right column-->
                        </div>

                        <div class="text-center pt-5">
                            <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Discard</button>
                            <button type="submit" class="btn btn-primary" id="btn-submit-product">
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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
<style>
    .image-input-wrapper { border-radius: 0.475rem; }
    #product-image-preview { border: 2px dashed #e4e6ef; border-radius: 0.475rem; }
    /* Match Select2 container to form-control-solid style */
    .select2-container--default .select2-selection--single {
        background-color: var(--bs-gray-100);
        border: 1px solid var(--bs-gray-100);
        border-radius: 0.475rem;
        height: calc(1.5em + 1.3rem + 2px);
        display: flex;
        align-items: center;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: var(--bs-gray-700);
        padding-left: 1rem;
        line-height: normal;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 100%;
        right: 0.75rem;
    }
    .select2-container--default .select2-selection--single .select2-selection__placeholder {
        color: var(--bs-gray-500);
    }
    .select2-dropdown {
        border: 1px solid var(--bs-gray-200);
        border-radius: 0.475rem;
        box-shadow: 0 0.5rem 1.5rem rgba(0,0,0,.075);
    }
    .select2-search--dropdown .select2-search__field {
        border: 1px solid var(--bs-gray-200);
        border-radius: 0.375rem;
        padding: 0.4rem 0.75rem;
        outline: none;
    }
    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: var(--bs-primary);
    }
    .select2-container.is-invalid .select2-selection--single {
        border-color: var(--bs-danger) !important;
    }
</style>
@endpush

@push('scripts')
<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
"use strict";

var productDt;
var productModal;
var categoriesCache = [];
var vendorsCache    = [];

var routes = {
    datatable: "{{ route('product.datatable') }}",
    options:   "{{ route('product.options') }}",
    store:     "{{ route('product.store') }}",
    update:    "{{ url('products') }}",
    destroy:   "{{ url('products') }}",
    csrf:      "{{ csrf_token() }}"
};

// ── Dropdown options ─────────────────────────────────────────────────────────

function loadOptions(callback) {
    if (categoriesCache.length && vendorsCache.length) {
        callback && callback();
        return;
    }
    $.ajax({
        url: routes.options,
        type: 'GET',
        headers: { 'X-CSRF-TOKEN': routes.csrf, 'Accept': 'application/json' },
        success: function (res) {
            categoriesCache = res.categories || [];
            vendorsCache    = res.vendors    || [];
            populateSelect('product-categoryId', categoriesCache);
            populateSelect('product-vendorId',   vendorsCache);
            callback && callback();
        }
    });
}

function populateSelect(selectId, items) {
    var $select = $('#' + selectId);
    var current = $select.val();
    $select.find('option:not(:first)').remove();
    items.forEach(function (item) {
        $select.append(new Option(item.name, item.id, false, false));
    });
    if (current) $select.val(current).trigger('change');
}

// ── Image preview ─────────────────────────────────────────────────────────────

document.getElementById('product-image-input').addEventListener('change', function () {
    var file = this.files[0];
    if (!file) return;
    var reader = new FileReader();
    reader.onload = function (e) {
        document.getElementById('product-image-preview').style.backgroundImage = 'url(' + e.target.result + ')';
        document.getElementById('btn-remove-image').style.display = '';
    };
    reader.readAsDataURL(file);
});

document.getElementById('btn-remove-image').addEventListener('click', function () {
    document.getElementById('product-image-input').value = '';
    document.getElementById('product-image-preview').style.backgroundImage = "url('{{ asset('assets/media/svg/avatars/blank.svg') }}')";
    this.style.display = 'none';
});

// ── DataTable ─────────────────────────────────────────────────────────────────

function initProductDatatable() {
    productDt = $('#kt_datatable_products').DataTable({
        searchDelay: 500,
        processing: true,
        serverSide: true,
        ordering: true,
        order: [[1, 'asc']],
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
            { data: 'imageUrl', name: 'imageUrl', orderable: false, searchable: false },
            { data: 'name',         name: 'name' },
            { data: 'sku',          name: 'sku' },
            { data: 'categoryName', name: 'categoryName' },
            { data: 'vendorName',   name: 'vendorName' },
            { data: 'basePrice',    name: 'basePrice' },
            { data: 'uoM',          name: 'uoM' },
            { data: null,           name: 'actions', orderable: false, searchable: false }
        ],
        columnDefs: [
            {
                targets: 0,
                render: function (data, type, row) {
                    if (!data) return '<span class="text-muted">—</span>';
                    return '<img src="' + data + '" class="rounded" style="width:48px;height:48px;object-fit:cover;" alt="product"/>';
                }
            },
            {
                targets: 5,
                render: function (data) {
                    if (data == null) return '—';
                    return 'Rp ' + Number(data).toLocaleString('id-ID');
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
                                <a href="#" class="menu-link px-3 btn-edit-product"
                                   data-row='${JSON.stringify(row)}'>Edit</a>
                            </div>
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3 text-danger btn-delete-product"
                                   data-id="${row.id}" data-name="${row.name || ''}">Delete</a>
                            </div>
                        </div>`;
                }
            }
        ]
    });

    productDt.on('draw', function () {
        KTMenu.createInstances();
        bindRowActions();
    });
}

function initSearch() {
    document.getElementById('product-search').addEventListener('keyup', function (e) {
        productDt.search(e.target.value).draw();
    });
}

// ── Modal open ────────────────────────────────────────────────────────────────

function openModal(title, row) {
    document.getElementById('modal-product-title').textContent = title;
    document.getElementById('product-id').value        = row ? (row.id || '')         : '';
    document.getElementById('product-name').value      = row ? (row.name || '')       : '';
    document.getElementById('product-sku').value       = row ? (row.sku || '')        : '';
    document.getElementById('product-uom').value       = row ? (row.uoM || '')        : '';
    document.getElementById('product-basePrice').value = row ? (row.basePrice || '')  : '';
    document.getElementById('product-detail').value    = row ? (row.desc || '')     : '';

    var blankImg = "url('{{ asset('assets/media/svg/avatars/blank.svg') }}')";
    var imgEl    = document.getElementById('product-image-preview');
    var removeBtn = document.getElementById('btn-remove-image');

    if (row && row.imageUrl) {
        imgEl.style.backgroundImage = 'url(' + row.imageUrl + ')';
        removeBtn.style.display = '';
    } else {
        imgEl.style.backgroundImage = blankImg;
        removeBtn.style.display = 'none';
    }

    clearErrors();

    var pendingCategoryId = row ? (row.categoryId || '') : '';
    var pendingVendorId   = row ? (row.vendorId   || '') : '';

    loadOptions(function () {
        // If Select2 is already active (modal already visible), set immediately.
        // Otherwise defer until shown.bs.modal fires.
        if ($('#product-categoryId').data('select2')) {
            $('#product-categoryId').val(pendingCategoryId).trigger('change');
            $('#product-vendorId').val(pendingVendorId).trigger('change');
        } else {
            $('#modal-product').one('shown.bs.modal', function () {
                $('#product-categoryId').val(pendingCategoryId).trigger('change');
                $('#product-vendorId').val(pendingVendorId).trigger('change');
            });
        }
    });

    productModal = bootstrap.Modal.getOrCreateInstance(document.getElementById('modal-product'));
    productModal.show();
}

document.getElementById('btn-create-product').addEventListener('click', function () {
    openModal('Add Product', null);
});

// ── Row actions ───────────────────────────────────────────────────────────────

function bindRowActions() {
    document.querySelectorAll('.btn-edit-product').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            var row = JSON.parse(this.dataset.row);
            openModal('Edit Product', row);
        });
    });

    document.querySelectorAll('.btn-delete-product').forEach(function (btn) {
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
                            text: res.message || 'Product deleted.',
                            icon: 'success',
                            buttonsStyling: false,
                            confirmButtonText: 'Ok, got it!',
                            customClass: { confirmButton: 'btn fw-bold btn-primary' }
                        }).then(function () { productDt.draw(); });
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

// ── Form submit ───────────────────────────────────────────────────────────────

document.getElementById('form-product').addEventListener('submit', function (e) {
    e.preventDefault();

    var name       = document.getElementById('product-name').value.trim();
    var sku        = document.getElementById('product-sku').value.trim();
    var categoryId = document.getElementById('product-categoryId').value;
    var vendorId   = document.getElementById('product-vendorId').value;
    var basePrice  = document.getElementById('product-basePrice').value.trim();
    var uom        = document.getElementById('product-uom').value.trim();
    var valid      = true;

    clearErrors();

    if (!name)       { showFieldError('product-name',       'product-name-error',       'Product name is required.');   valid = false; }
    if (!sku)        { showFieldError('product-sku',        'product-sku-error',        'SKU is required.');            valid = false; }
    if (!categoryId) { showFieldError('product-categoryId', 'product-categoryId-error', 'Category is required.');       valid = false; }
    if (!vendorId)   { showFieldError('product-vendorId',   'product-vendorId-error',   'Vendor is required.');         valid = false; }
    if (!basePrice)  { showFieldError('product-basePrice',  'product-basePrice-error',  'Base price is required.');     valid = false; }
    if (!uom)        { showFieldError('product-uom',        'product-uom-error',        'Unit of measure is required.'); valid = false; }

    if (!valid) return;

    var id    = document.getElementById('product-id').value.trim();
    var $btn  = document.getElementById('btn-submit-product');
    $btn.setAttribute('data-kt-indicator', 'on');
    $btn.disabled = true;

    var formData = new FormData();
    formData.append('SKU',        sku);
    formData.append('Name',       name);
    formData.append('CategoryId', categoryId);
    formData.append('VendorId',   vendorId);
    formData.append('BasePrice',  basePrice);
    formData.append('UoM',        uom);
    formData.append('Detail',     document.getElementById('product-detail').value.trim());

    var isEdit = id !== '';

    var imageFile = document.getElementById('product-image-input').files[0];
    if (imageFile) {
        formData.append('ProductImage', imageFile);
    } else if (isEdit) {
        formData.append('ProductImage', '');
    }
    var url = isEdit ? routes.update + '/' + id : routes.store;

    if (isEdit) {
        formData.append('_method', 'PUT');
    }

    $.ajax({
        url: url,
        type: isEdit ? 'POST' : 'POST',
        headers: { 'X-CSRF-TOKEN': routes.csrf, 'Accept': 'application/json' },
        data: formData,
        processData: false,
        contentType: false,
        success: function (res) {
            $btn.removeAttribute('data-kt-indicator');
            $btn.disabled = false;
            productModal.hide();
            $('#modal-product').one('hidden.bs.modal', function () {
                Swal.fire({
                    text: res.message || 'Product saved.',
                    icon: 'success',
                    buttonsStyling: false,
                    confirmButtonText: 'Ok, got it!',
                    customClass: { confirmButton: 'btn fw-bold btn-primary' }
                }).then(function () { productDt.draw(); });
            });
        },
        error: function (xhr) {
            $btn.removeAttribute('data-kt-indicator');
            $btn.disabled = false;
            var res = xhr.responseJSON || {};
            if (res.errors) {
                var fieldMap = { SKU: 'product-sku', Name: 'product-name', CategoryId: 'product-categoryId', VendorId: 'product-vendorId', BasePrice: 'product-basePrice', UoM: 'product-uom', Detail: 'product-detail' };
                Object.keys(res.errors).forEach(function (field) {
                    var inputId = fieldMap[field];
                    if (inputId) showFieldError(inputId, inputId + '-error', res.errors[field][0]);
                });
            } else {
                Swal.fire({ text: res.message || 'Something went wrong.', icon: 'error', buttonsStyling: false, confirmButtonText: 'Ok, got it!', customClass: { confirmButton: 'btn fw-bold btn-primary' } });
            }
        }
    });
});

// ── Helpers ───────────────────────────────────────────────────────────────────

var select2Fields = ['product-categoryId', 'product-vendorId'];

function showFieldError(inputId, errorId, msg) {
    if (select2Fields.indexOf(inputId) !== -1) {
        // Mark the Select2 container instead of the hidden <select>
        $('#' + inputId).next('.select2-container').addClass('is-invalid');
    } else {
        var el = document.getElementById(inputId);
        if (el) el.classList.add('is-invalid');
    }
    var err = document.getElementById(errorId);
    if (err) err.textContent = msg;
}

function clearErrors() {
    var fields = ['product-name', 'product-sku', 'product-categoryId', 'product-vendorId', 'product-basePrice', 'product-uom', 'product-detail'];
    fields.forEach(function (id) {
        if (select2Fields.indexOf(id) !== -1) {
            $('#' + id).next('.select2-container').removeClass('is-invalid');
        } else {
            var el = document.getElementById(id);
            if (el) el.classList.remove('is-invalid');
        }
        var err = document.getElementById(id + '-error');
        if (err) err.textContent = '';
    });
}

// ── Select2 ───────────────────────────────────────────────────────────────────

function initSelect2() {
    $('#product-categoryId').select2({
        placeholder: 'Select category...',
        allowClear: true,
        dropdownParent: $('#modal-product')
    });
    $('#product-vendorId').select2({
        placeholder: 'Select vendor...',
        allowClear: true,
        dropdownParent: $('#modal-product')
    });
}

function destroySelect2() {
    if ($('#product-categoryId').data('select2')) $('#product-categoryId').select2('destroy');
    if ($('#product-vendorId').data('select2'))   $('#product-vendorId').select2('destroy');
}

// ── Boot ──────────────────────────────────────────────────────────────────────

KTUtil.onDOMContentLoaded(function () {
    initProductDatatable();
    initSearch();
    loadOptions();

    var $modal = $('#modal-product');
    $modal.on('shown.bs.modal', function () { initSelect2(); });
    $modal.on('hidden.bs.modal', function () { destroySelect2(); });
});
</script>
@endpush
