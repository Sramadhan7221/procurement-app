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

                @php
                    $pr         = $procurementRequest;
                    $isEdit     = !is_null($pr);
                    $status     = $isEdit ? (int)($pr['status'] ?? 0) : 0;
                    $isEditable = !$isEdit || $status === 1;
                @endphp

                @if($isEdit)
                <div class="alert alert-{{ $status === 1 ? 'info' : 'warning' }} d-flex align-items-center p-5 mb-6">
                    <i class="ki-duotone ki-information-5 fs-2hx me-4">
                        <span class="path1"></span><span class="path2"></span><span class="path3"></span>
                    </i>
                    <div>
                        @if($status === 1)
                            You are editing an existing procurement request. All fields are editable.
                        @else
                            This request has status <strong id="status-badge-inline"></strong> and cannot be edited.
                        @endif
                    </div>
                </div>
                @endif

                <div class="card card-flush">
                    <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                        <div class="card-title">
                            <h3 class="card-label fw-bold fs-3 mb-1" id="form-card-title">
                                {{ $isEdit ? 'Edit Procurement Request' : 'Create Procurement Request' }}
                            </h3>
                        </div>
                        @if($isEdit && $status !== 1)
                        <div class="card-toolbar">
                            <span class="badge fs-6 fw-bold" id="status-badge-card"></span>
                        </div>
                        @endif
                    </div>
                    <div class="card-body pt-0">
                        <form id="form-procurement" class="form">
                            <input type="hidden" id="pr-id" value="{{ $isEdit ? ($pr['id'] ?? '') : '' }}"/>

                            <div class="row mb-7">
                                <div class="col-md-8">
                                    <label class="required fw-semibold fs-6 mb-2">Request Title</label>
                                    <input type="text" id="pr-title"
                                           class="form-control form-control-solid"
                                           placeholder="e.g. Office Supplies Q2 2026"
                                           value="{{ $isEdit ? ($pr['title'] ?? '') : '' }}"
                                           {{ !$isEditable ? 'readonly' : '' }}/>
                                    <div class="invalid-feedback" id="pr-title-error"></div>
                                </div>
                                <div class="col-md-4">
                                    <label class="required fw-semibold fs-6 mb-2">Request Date</label>
                                    <input type="date" id="pr-request-date"
                                           class="form-control form-control-solid"
                                           value="{{ $isEdit ? ($pr['requestDate'] ?? '') : date('Y-m-d') }}"
                                           {{ !$isEditable ? 'readonly' : '' }}/>
                                    <div class="invalid-feedback" id="pr-request-date-error"></div>
                                </div>
                            </div>

                            <div class="mb-7">
                                <label class="fw-semibold fs-6 mb-2">Notes</label>
                                <textarea id="pr-notes" rows="3"
                                          class="form-control form-control-solid"
                                          placeholder="Additional information or context for this request"
                                          {{ !$isEditable ? 'readonly' : '' }}>{{ $isEdit ? ($pr['notes'] ?? '') : '' }}</textarea>
                            </div>

                            <!--begin::Items-->
                            <div class="mb-5">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <label class="required fw-semibold fs-6">Request Items</label>
                                    @if($isEditable)
                                    <button type="button" class="btn btn-sm btn-light-primary" id="btn-add-item">
                                        <i class="ki-duotone ki-plus fs-4"></i> Add Item
                                    </button>
                                    @endif
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered align-middle fs-6" id="items-table">
                                        <thead class="table-light">
                                            <tr class="fw-bold text-gray-600 text-uppercase fs-7">
                                                <th class="min-w-200px">Item Name</th>
                                                <th class="min-w-80px">Qty</th>
                                                <th class="min-w-100px">Unit</th>
                                                <th class="min-w-150px">Unit Price (Rp)</th>
                                                <th class="min-w-150px">Total (Rp)</th>
                                                @if($isEditable)
                                                <th class="w-50px"></th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody id="items-tbody">
                                            @if($isEdit && !empty($pr['items']))
                                                @foreach($pr['items'] as $item)
                                                <tr class="item-row">
                                                    <td><input type="text" class="form-control form-control-sm item-name" value="{{ $item['name'] ?? '' }}" placeholder="Item name" {{ !$isEditable ? 'readonly' : '' }}/></td>
                                                    <td><input type="number" class="form-control form-control-sm item-qty" value="{{ $item['quantity'] ?? 1 }}" min="1" {{ !$isEditable ? 'readonly' : '' }}/></td>
                                                    <td><input type="text" class="form-control form-control-sm item-unit" value="{{ $item['unit'] ?? '' }}" placeholder="pcs / box / kg" {{ !$isEditable ? 'readonly' : '' }}/></td>
                                                    <td><input type="number" class="form-control form-control-sm item-price" value="{{ $item['unitPrice'] ?? 0 }}" min="0" {{ !$isEditable ? 'readonly' : '' }}/></td>
                                                    <td><input type="text" class="form-control form-control-sm item-total bg-light" readonly value="{{ number_format(($item['quantity'] ?? 1) * ($item['unitPrice'] ?? 0), 0, ',', '.') }}"/></td>
                                                    @if($isEditable)
                                                    <td><button type="button" class="btn btn-icon btn-sm btn-light-danger btn-remove-item"><i class="ki-duotone ki-trash fs-5"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i></button></td>
                                                    @endif
                                                </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="{{ $isEditable ? 4 : 4 }}" class="text-end fw-bold">Grand Total</td>
                                                <td><input type="text" id="grand-total" class="form-control form-control-sm bg-light fw-bold" readonly value="0"/></td>
                                                @if($isEditable)
                                                <td></td>
                                                @endif
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <div class="invalid-feedback d-block" id="pr-items-error"></div>
                                </div>
                            </div>
                            <!--end::Items-->

                            @if($isEditable)
                            <div class="text-end pt-5">
                                <a href="{{ route('home') }}" class="btn btn-light me-3">Cancel</a>
                                <button type="submit" class="btn btn-primary" id="btn-submit-pr">
                                    <span class="indicator-label">{{ $isEdit ? 'Update Request' : 'Submit Request' }}</span>
                                    <span class="indicator-progress">
                                        Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </span>
                                </button>
                            </div>
                            @endif
                        </form>
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

    <!--begin::Product Picker Modal-->
    <div class="modal fade" id="modal-product-picker" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="fw-bold">Select Products</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                </div>
                <div class="modal-body px-5 py-5">
                    <!--begin::Filter row-->
                    <div class="d-flex align-items-end gap-4 mb-5">
                        <div style="min-width: 280px;">
                            <label class="fw-semibold fs-6 mb-2">Filter by Category</label>
                            <select id="picker-category-id" class="form-select form-select-solid" style="width:100%;">
                                <option value="">All categories</option>
                            </select>
                        </div>
                        <button type="button" class="btn btn-primary" id="btn-apply-product-filter">
                            <i class="ki-duotone ki-filter fs-4 me-1"><span class="path1"></span><span class="path2"></span></i>
                            Apply Filter
                        </button>
                    </div>
                    <!--end::Filter row-->

                    <!--begin::Placeholder (shown before first filter apply)-->
                    <div id="picker-placeholder" class="text-center text-muted py-10 border rounded">
                        <i class="ki-duotone ki-filter fs-2x mb-3 d-block">
                            <span class="path1"></span><span class="path2"></span>
                        </i>
                        Select a category and click "Apply Filter" to load products.
                    </div>
                    <!--end::Placeholder-->

                    <!--begin::Product datatable (hidden until first Apply Filter)-->
                    <div id="picker-table-wrapper" class="table-responsive" style="display:none;">
                        <table id="kt_datatable_product_picker" class="table align-middle table-row-dashed fs-6 gy-3">
                            <thead>
                                <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                    <th class="w-30px pe-2">
                                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" id="picker-check-all"/>
                                        </div>
                                    </th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>UoM</th>
                                    <th>Base Price</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <!--end::Product datatable-->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" id="btn-picker-abort">Abort</button>
                    <button type="button" class="btn btn-primary" id="btn-add-products">
                        <i class="ki-duotone ki-plus fs-4 me-1"></i>
                        Add Products
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!--end::Product Picker Modal-->
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
<style>
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
</style>
@endpush

@push('scripts')
<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
"use strict";

var routes = {
    store:              "{{ route('procurement-request.store') }}",
    productsDataTable:  "{{ $apiUrls['productsDataTable'] }}",
    categoriesOptions:  "{{ $apiUrls['categoriesOptions'] }}",
    csrf:               "{{ csrf_token() }}"
};

var statusMap = {
    1: { label: 'Request Created',      cls: 'badge-light-primary' },
    2: { label: 'Approved by Manager',  cls: 'badge-light-info'    },
    3: { label: 'Rejected by Manager',  cls: 'badge-light-danger'  },
    4: { label: 'Approved by Admin',    cls: 'badge-light-success' },
    5: { label: 'Rejected by Admin',    cls: 'badge-light-danger'  },
    6: { label: 'In Order',             cls: 'badge-light-warning' },
    7: { label: 'Order Received',       cls: 'badge-secondary'     },
    8: { label: 'Completed',            cls: 'badge-success'       },
};

var currentStatus = {{ $status }};

function getStatusBadge(status) {
    var s = statusMap[status] || { label: 'Unknown', cls: 'badge-light' };
    return '<span class="badge ' + s.cls + '">' + s.label + '</span>';
}

function formatNumber(n) {
    return Number(n).toLocaleString('id-ID');
}

function recalcRow(row) {
    var qty   = parseFloat($(row).find('.item-qty').val())   || 0;
    var price = parseFloat($(row).find('.item-price').val()) || 0;
    $(row).find('.item-total').val(formatNumber(qty * price));
}

function recalcGrandTotal() {
    var total = 0;
    $('#items-tbody .item-row').each(function () {
        var qty   = parseFloat($(this).find('.item-qty').val())   || 0;
        var price = parseFloat($(this).find('.item-price').val()) || 0;
        total += qty * price;
    });
    $('#grand-total').val(formatNumber(total));
}

function addItemRow(name, qty, unit, price, productId) {
    var displayQty = (qty != null) ? qty : 1;
    var pidAttr    = productId ? ' data-product-id="' + productId + '"' : '';
    var row = $('<tr class="item-row"' + pidAttr + '></tr>');
    row.html(
        '<td><input type="text"   class="form-control form-control-sm item-name"  value="' + (name  || '') + '" placeholder="Item name"/></td>' +
        '<td><input type="number" class="form-control form-control-sm item-qty"   value="' + displayQty   + '" min="0"/></td>' +
        '<td><input type="text"   class="form-control form-control-sm item-unit"  value="' + (unit  || '') + '" placeholder="pcs / box / kg"/></td>' +
        '<td><input type="number" class="form-control form-control-sm item-price" value="' + (price || 0)  + '" min="0"/></td>' +
        '<td><input type="text"   class="form-control form-control-sm item-total bg-light" readonly value="' + formatNumber(displayQty * (price || 0)) + '"/></td>' +
        '<td><button type="button" class="btn btn-icon btn-sm btn-light-danger btn-remove-item">' +
            '<i class="ki-duotone ki-trash fs-5"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>' +
        '</button></td>'
    );
    $('#items-tbody').append(row);
    row.on('input', '.item-qty, .item-price', function () { recalcRow(row); recalcGrandTotal(); });
    row.find('.btn-remove-item').on('click', function () { row.remove(); recalcGrandTotal(); });
}

function collectItems() {
    var items = [];
    $('#items-tbody .item-row').each(function () {
        items.push({
            itemName:      $(this).find('.item-name').val().trim(),
            quantity:  parseFloat($(this).find('.item-qty').val())   || 0,
            uoM:      $(this).find('.item-unit').val().trim(),
            unitPrice: parseFloat($(this).find('.item-price').val()) || 0,
        });
    });
    return items;
}

function clearErrors() {
    ['pr-title', 'pr-request-date'].forEach(function (id) {
        document.getElementById(id).classList.remove('is-invalid');
        document.getElementById(id + '-error').textContent = '';
    });
    document.getElementById('pr-items-error').textContent = '';
}

function showFieldError(field, msg) {
    document.getElementById(field).classList.add('is-invalid');
    document.getElementById(field + '-error').textContent = msg;
}

// ── Product Picker ────────────────────────────────────────────────────────────

var productPickerDt  = null;
var pickerCategoryId = '';

function initProductPickerDt() {
    productPickerDt = $('#kt_datatable_product_picker').DataTable({
        serverSide:  true,
        processing:  true,
        ordering:    false,
        ajax: {
            url:         routes.productsDataTable,
            type:        'POST',
            headers:     { 'X-CSRF-TOKEN': routes.csrf },
            contentType: 'application/json',
            data: function (d) {
                return JSON.stringify({
                    draw:       d.draw,
                    start:      d.start,
                    length:     d.length,
                    search:     { value: d.search.value, regex: d.search.regex },
                    order:      [],
                    columns:    (d.columns || []).map(function (c) {
                        return { data: c.data, name: c.name, searchable: c.searchable, orderable: c.orderable };
                    }),
                    categoryId: pickerCategoryId || null
                });
            },
            dataSrc: function (json) { return json.data || []; }
        },
        columns: [
            { data: 'id',           orderable: false, searchable: false, className: 'pe-2 w-30px' },
            { data: 'name',         name: 'name' },
            { data: 'categoryName', name: 'categoryName', orderable: false },
            { data: 'uoM',          name: 'uoM',          orderable: false },
            { data: 'basePrice',    name: 'basePrice',    orderable: false }
        ],
        columnDefs: [
            {
                targets: 0,
                render: function (data, type, row) {
                    var rowJson = JSON.stringify({
                        id:        row.id,
                        name:      row.name      || '',
                        uoM:       row.uoM       || '',
                        basePrice: row.basePrice || 0
                    });
                    return '<div class="form-check form-check-sm form-check-custom form-check-solid">' +
                        '<input class="form-check-input product-picker-check" type="checkbox" ' +
                        'data-row=\'' + rowJson.replace(/'/g, '&#39;') + '\'>' +
                        '</div>';
                }
            },
            {
                targets: 4,
                render: function (data) {
                    return data != null ? 'Rp ' + Number(data).toLocaleString('id-ID') : '—';
                }
            }
        ]
    });

    productPickerDt.on('draw', function () {
        document.getElementById('picker-check-all').checked = false;
    });
}

function loadPickerCategories() {
    $.ajax({
        url:     routes.categoriesOptions,
        type:    'GET',
        headers: { 'X-CSRF-TOKEN': routes.csrf, 'Accept': 'application/json' },
        success: function (res) {
            var $sel = $('#picker-category-id');
            $sel.find('option:not(:first)').remove();
            (res.data || []).forEach(function (cat) {
                $sel.append(new Option(cat.name, cat.id, false, false));
            });
            if ($sel.data('select2')) $sel.trigger('change');
        }
    });
}

function initSelect2Picker() {
    if ($('#picker-category-id').data('select2')) return;
    $('#picker-category-id').select2({
        placeholder:    'All categories',
        allowClear:     true,
        dropdownParent: $('#modal-product-picker')
    });
}

function destroySelect2Picker() {
    if ($('#picker-category-id').data('select2')) {
        $('#picker-category-id').select2('destroy');
    }
}

KTUtil.onDOMContentLoaded(function () {
    if (currentStatus > 0) {
        var badge = getStatusBadge(currentStatus);
        var inl  = document.getElementById('status-badge-inline');
        var card = document.getElementById('status-badge-card');
        if (inl)  inl.innerHTML  = badge;
        if (card) card.innerHTML = badge;
    }

    // Bind existing rows (edit mode)
    $('#items-tbody .item-row').each(function () {
        var row = this;
        $(row).on('input', '.item-qty, .item-price', function () { recalcRow(row); recalcGrandTotal(); });
        $(row).find('.btn-remove-item').on('click', function () { $(row).remove(); recalcGrandTotal(); });
    });

    recalcGrandTotal();

    // "Add Item" button → open product picker modal
    var btnAdd = document.getElementById('btn-add-item');
    if (btnAdd) {
        btnAdd.addEventListener('click', function () {
            bootstrap.Modal.getOrCreateInstance(document.getElementById('modal-product-picker')).show();
        });
    }

    // ── Product Picker modal events ───────────────────────────────────────────

    var $pickerModal = $('#modal-product-picker');

    $pickerModal.on('show.bs.modal', function () {
        pickerCategoryId = '';
        // Destroy any previous DataTable instance and reset to placeholder state
        if (productPickerDt) {
            productPickerDt.destroy();
            productPickerDt = null;
        }
        document.getElementById('picker-placeholder').style.display   = '';
        document.getElementById('picker-table-wrapper').style.display = 'none';
    });

    $pickerModal.on('shown.bs.modal', function () {
        initSelect2Picker();
        loadPickerCategories();
        $('#picker-category-id').val('').trigger('change.select2');
    });

    $pickerModal.on('hidden.bs.modal', function () {
        destroySelect2Picker();
    });

    document.getElementById('btn-apply-product-filter').addEventListener('click', function () {
        pickerCategoryId = $('#picker-category-id').val() || '';

        document.getElementById('picker-placeholder').style.display   = 'none';
        document.getElementById('picker-table-wrapper').style.display = '';

        if (!productPickerDt) {
            // First apply: initialise the DataTable while the table is visible
            initProductPickerDt();
        } else {
            productPickerDt.ajax.reload();
        }
    });

    document.getElementById('picker-check-all').addEventListener('change', function () {
        var checked = this.checked;
        $('#kt_datatable_product_picker tbody .product-picker-check').each(function () {
            this.checked = checked;
        });
    });

    document.getElementById('btn-picker-abort').addEventListener('click', function () {
        bootstrap.Modal.getInstance(document.getElementById('modal-product-picker')).hide();
    });

    document.getElementById('btn-add-products').addEventListener('click', function () {
        var selected = [];
        $('#kt_datatable_product_picker tbody .product-picker-check:checked').each(function () {
            selected.push($(this).data('row'));
        });

        if (selected.length === 0) {
            Swal.fire({
                text:              'Please select at least one product.',
                icon:              'warning',
                buttonsStyling:    false,
                confirmButtonText: 'Ok, got it!',
                customClass:       { confirmButton: 'btn fw-bold btn-primary' }
            });
            return;
        }

        var existingIds = [];
        $('#items-tbody .item-row').each(function () {
            var pid = $(this).data('product-id');
            if (pid != null) existingIds.push(String(pid));
        });

        var toAdd      = [];
        var duplicates = [];
        selected.forEach(function (row) {
            if (existingIds.indexOf(String(row.id)) !== -1) {
                duplicates.push(row.name);
            } else {
                toAdd.push(row);
            }
        });

        toAdd.forEach(function (row) {
            addItemRow(row.name, 0, row.uoM, row.basePrice, row.id);
        });

        recalcGrandTotal();
        bootstrap.Modal.getInstance(document.getElementById('modal-product-picker')).hide();

        if (duplicates.length > 0) {
            Swal.fire({
                text:              duplicates.length + ' product(s) already in the list were skipped: ' + duplicates.join(', '),
                icon:              'info',
                buttonsStyling:    false,
                confirmButtonText: 'Ok, got it!',
                customClass:       { confirmButton: 'btn fw-bold btn-primary' }
            });
        }
    });

    // ── Main form submit ──────────────────────────────────────────────────────

    document.getElementById('form-procurement').addEventListener('submit', function (e) {
        e.preventDefault();
        clearErrors();

        var id          = document.getElementById('pr-id').value.trim();
        var title       = document.getElementById('pr-title').value.trim();
        var requestDate = document.getElementById('pr-request-date').value.trim();
        var notes       = document.getElementById('pr-notes').value.trim();
        var items       = collectItems();

        var valid = true;
        if (!title)       { showFieldError('pr-title', 'Request title is required.');        valid = false; }
        if (!requestDate) { showFieldError('pr-request-date', 'Request date is required.'); valid = false; }
        if (items.length === 0) {
            document.getElementById('pr-items-error').textContent = 'At least one item is required.';
            valid = false;
        } else {
            for (var i = 0; i < items.length; i++) {
                if (!items[i].itemName) {
                    document.getElementById('pr-items-error').textContent = 'All items must have a name.';
                    valid = false; break;
                }
                if (!items[i].uoM) {
                    document.getElementById('pr-items-error').textContent = 'All items must have a Unit of measurement.';
                    valid = false; break;
                }
                if (items[i].quantity <= 0) {
                    document.getElementById('pr-items-error').textContent = 'All item quantities must be greater than 0.';
                    valid = false; break;
                }
            }
        }
        if (!valid) return;

        var payload = { title: title, requestDate: requestDate, notes: notes, items: items, createdByUserId: "{{ session('user_id') }}"};
        if (id) payload.id = id;

        var $btn = document.getElementById('btn-submit-pr');
        $btn.setAttribute('data-kt-indicator', 'on');
        $btn.disabled = true;

        $.ajax({
            url:     routes.store,
            type:    'POST',
            headers: { 'X-CSRF-TOKEN': routes.csrf, 'Accept': 'application/json', 'Content-Type': 'application/json' },
            data:    JSON.stringify(payload),
            success: function (res) {
                $btn.removeAttribute('data-kt-indicator');
                $btn.disabled = false;
                Swal.fire({
                    text:              res.message || 'Request submitted.',
                    icon:              'success',
                    buttonsStyling:    false,
                    confirmButtonText: 'Ok, got it!',
                    customClass:       { confirmButton: 'btn fw-bold btn-primary' }
                }).then(function () {
                    if (!id) {
                        document.getElementById('form-procurement').reset();
                        $('#items-tbody').empty();
                        recalcGrandTotal();
                    }
                });
            },
            error: function (xhr) {
                $btn.removeAttribute('data-kt-indicator');
                $btn.disabled = false;
                var res = xhr.responseJSON || {};
                if (res.errors) {
                    if (res.errors.title)       showFieldError('pr-title', res.errors.title[0]);
                    if (res.errors.requestDate) showFieldError('pr-request-date', res.errors.requestDate[0]);
                    if (res.errors.items)       document.getElementById('pr-items-error').textContent = res.errors.items[0];
                } else {
                    Swal.fire({ text: res.message || 'Something went wrong.', icon: 'error', buttonsStyling: false, confirmButtonText: 'Ok, got it!', customClass: { confirmButton: 'btn fw-bold btn-primary' } });
                }
            }
        });
    });
});
</script>
@endpush
