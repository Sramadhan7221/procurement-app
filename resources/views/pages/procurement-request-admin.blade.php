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
                        <!--begin::Search bar-->
                        <div class="d-flex flex-stack mb-5">
                            <div class="d-flex align-items-center position-relative my-1">
                                <i class="ki-duotone ki-magnifier fs-1 position-absolute ms-6">
                                    <span class="path1"></span><span class="path2"></span>
                                </i>
                                <input type="text" id="pr-search" class="form-control form-control-solid w-250px ps-15" placeholder="Search requests..."/>
                            </div>
                        </div>
                        <!--end::Search bar-->

                        <!--begin::Datatable-->
                        <table id="kt_datatable_pr_admin" class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                                <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                    <th>Title</th>
                                    <th>Requested By</th>
                                    <th>Date</th>
                                    <th>Status</th>
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

    <!--begin::Detail Modal-->
    <div class="modal fade" id="modal-pr-detail" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="fw-bold" id="modal-pr-title">Request Detail</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                </div>
                <div class="modal-body p-0">
                    <!--begin::Tabs-->
                    <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x fs-6 px-5 pt-3" id="admin-modal-tabs">
                        <li class="nav-item">
                            <a class="nav-link active fw-semibold" data-bs-toggle="tab" href="#tab-detail">Request</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-semibold" data-bs-toggle="tab" href="#tab-po">Purchase Order</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-semibold" data-bs-toggle="tab" href="#tab-invoice">Invoice</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-semibold" data-bs-toggle="tab" href="#tab-payment">Payment</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-semibold" data-bs-toggle="tab" href="#tab-timeline-admin">Timeline</a>
                        </li>
                    </ul>
                    <!--end::Tabs-->

                    <div class="tab-content px-5 py-5">
                        <!--begin::TAB 1 — Request Detail-->
                        <div class="tab-pane fade show active" id="tab-detail">
                            <div class="row mb-5">
                                <div class="col-md-8">
                                    <div class="mb-4">
                                        <span class="fw-bold text-gray-600 fs-7 text-uppercase">Title</span>
                                        <p class="fw-semibold fs-6 mt-1" id="detail-title">—</p>
                                    </div>
                                    <div class="mb-4">
                                        <span class="fw-bold text-gray-600 fs-7 text-uppercase">Notes</span>
                                        <p class="fw-semibold fs-6 mt-1" id="detail-notes">—</p>
                                    </div>
                                    <div class="mb-4">
                                        <span class="fw-bold text-gray-600 fs-7 text-uppercase">Manager Comment</span>
                                        <p class="fw-semibold fs-6 mt-1" id="detail-manager-comment">—</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-4">
                                        <span class="fw-bold text-gray-600 fs-7 text-uppercase">Requested By</span>
                                        <p class="fw-semibold fs-6 mt-1" id="detail-requester">—</p>
                                    </div>
                                    <div class="mb-4">
                                        <span class="fw-bold text-gray-600 fs-7 text-uppercase">Request Date</span>
                                        <p class="fw-semibold fs-6 mt-1" id="detail-date">—</p>
                                    </div>
                                    <div class="mb-4">
                                        <span class="fw-bold text-gray-600 fs-7 text-uppercase">Status</span>
                                        <p class="mt-1" id="detail-status">—</p>
                                    </div>
                                </div>
                            </div>

                            <!--begin::Items-->
                            <div class="mb-5">
                                <span class="fw-bold text-gray-600 fs-7 text-uppercase">Items</span>
                                <div class="table-responsive mt-2">
                                    <table class="table table-bordered table-sm align-middle fs-7">
                                        <thead class="table-light">
                                            <tr class="fw-bold text-uppercase text-gray-600">
                                                <th>#</th><th>Item Name</th><th>Qty</th><th>Unit</th><th>Unit Price</th><th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody id="detail-items-tbody">
                                            <tr><td colspan="6" class="text-center text-muted">No items</td></tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!--end::Items-->

                            <!--begin::Admin review (status = 2)-->
                            <div class="separator mb-5" id="action-separator" style="display:none;"></div>
                            <div id="comment-section" style="display:none;">
                                <div class="mb-5">
                                    <label class="fw-semibold fs-6 mb-2">Comment <span class="text-muted fs-7">(optional)</span></label>
                                    <textarea id="review-comment" rows="3" class="form-control form-control-solid" placeholder="Enter your comment..."></textarea>
                                </div>
                            </div>
                            <div id="admin-review-section" style="display:none;">
                                <div class="d-flex gap-3 justify-content-end">
                                    <button type="button" class="btn btn-danger" id="btn-reject">
                                        <span class="indicator-label"><i class="ki-duotone ki-cross-circle fs-4 me-1"><span class="path1"></span><span class="path2"></span></i>Reject</span>
                                        <span class="indicator-progress">Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    </button>
                                    <button type="button" class="btn btn-success" id="btn-approve">
                                        <span class="indicator-label"><i class="ki-duotone ki-check-circle fs-4 me-1"><span class="path1"></span><span class="path2"></span></i>Approve</span>
                                        <span class="indicator-progress">Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    </button>
                                </div>
                            </div>
                            <!--end::Admin review-->
                        </div>
                        <!--end::TAB 1-->

                        <!--begin::TAB 2 — Purchase Order-->
                        <div class="tab-pane fade" id="tab-po">
                            <div id="po-content">
                                <div class="text-center py-8 text-muted">
                                    <div class="spinner-border spinner-border-sm me-2"></div> Loading...
                                </div>
                            </div>
                        </div>
                        <!--end::TAB 2-->

                        <!--begin::TAB 3 — Invoice-->
                        <div class="tab-pane fade" id="tab-invoice">
                            <div id="invoice-content">
                                <div class="text-center py-8 text-muted">
                                    <div class="spinner-border spinner-border-sm me-2"></div> Loading...
                                </div>
                            </div>
                        </div>
                        <!--end::TAB 3-->

                        <!--begin::TAB 4 — Payment-->
                        <div class="tab-pane fade" id="tab-payment">
                            <div id="payment-content">
                                <div class="text-center py-8 text-muted">
                                    <div class="spinner-border spinner-border-sm me-2"></div> Loading...
                                </div>
                            </div>
                        </div>
                        <!--end::TAB 4-->

                        <!--begin::TAB 5 — Timeline-->
                        <div class="tab-pane fade" id="tab-timeline-admin">
                            <div id="admin-timeline-wrapper"></div>
                        </div>
                        <!--end::TAB 5-->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end::Detail Modal-->
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script>
"use strict";

var prDt;
var currentPrId     = null;
var currentPrStatus = null;

var baseUrl = "{{ url('procurement-requests') }}";

var routes = {
    datatable:    "{{ route('procurement-request.datatable') }}",
    show:         baseUrl,
    adminReview:  baseUrl,
    placeOrder:   baseUrl,
    purchaseOrder: baseUrl,
    goodsReceipt:  baseUrl,
    invoice:       baseUrl,
    payment:       baseUrl,
    csrf:         "{{ csrf_token() }}"
};

var userId = document.querySelector('meta[name="user-id"]') ? document.querySelector('meta[name="user-id"]').content : '';

var statusMap = {
    1:  { label: 'Request Created',   cls: 'badge-secondary' },
    2:  { label: 'Manager Approved',  cls: 'badge-info' },
    3:  { label: 'Manager Rejected',  cls: 'badge-danger' },
    4:  { label: 'Admin Approved',    cls: 'badge-primary' },
    5:  { label: 'Admin Rejected',    cls: 'badge-danger' },
    6:  { label: 'In Order',          cls: 'badge-warning' },
    7:  { label: 'Order Received',    cls: 'badge-info' },
    8:  { label: 'Completed',         cls: 'badge-success' },
    9:  { label: 'Invoice Uploaded',  cls: 'badge-warning' },
    10: { label: 'Invoice Disputed',  cls: 'badge-danger' },
    11: { label: 'Invoice Verified',  cls: 'badge-info' },
    12: { label: 'Payment Processed', cls: 'badge-primary' },
};

var progressMap = {
    4: { nextStatus: 6, label: 'Place Order' },
    6: { nextStatus: 7, label: 'Mark as Received' },
    7: { nextStatus: 8, label: 'Complete' },
};

function getStatusBadge(status) {
    var s = statusMap[status] || { label: 'Unknown', cls: 'badge-light' };
    return '<span class="badge ' + s.cls + '">' + s.label + '</span>';
}

function formatRupiah(n) {
    return 'Rp ' + Number(n).toLocaleString('id-ID');
}

function csrfHeaders(extra) {
    var h = { 'X-CSRF-TOKEN': routes.csrf, 'Accept': 'application/json' };
    return Object.assign(h, extra || {});
}

function showToast(msg, type) {
    Swal.fire({
        text: msg,
        icon: type || 'success',
        buttonsStyling: false,
        confirmButtonText: 'Ok, got it!',
        customClass: { confirmButton: 'btn fw-bold btn-primary' }
    });
}

// ─────────────────────────── Datatable ────────────────────────────────────────

function initDatatable() {
    prDt = $('#kt_datatable_pr_admin').DataTable({
        searchDelay: 500,
        processing:  true,
        serverSide:  true,
        ordering:    true,
        order:       [[2, 'desc']],
        ajax: {
            url:  routes.datatable,
            type: 'POST',
            headers: { 'X-CSRF-TOKEN': routes.csrf },
            contentType: 'application/json',
            data: function (d) {
                return JSON.stringify({
                    draw:    d.draw,
                    start:   d.start,
                    length:  d.length,
                    search:  { value: d.search.value, regex: d.search.regex },
                    order:   (d.order || []).map(function (o) { return { column: o.column, dir: o.dir }; }),
                    columns: (d.columns || []).map(function (c) { return { data: c.data, name: c.name, searchable: c.searchable, orderable: c.orderable }; })
                });
            },
            dataSrc: function (json) { return json.data || []; }
        },
        columns: [
            { data: 'title',         name: 'title' },
            { data: 'createdByName', name: 'createdByName' },
            { data: 'requestDate',   name: 'requestDate' },
            { data: 'status',        name: 'status', orderable: false },
            { data: null,            name: 'actions', orderable: false, searchable: false }
        ],
        columnDefs: [
            { targets: 3, render: function (data) { return getStatusBadge(data); } },
            {
                targets: -1,
                className: 'text-end',
                render: function (data, type, row) {
                    return '<button class="btn btn-sm btn-light-primary btn-view-detail" data-id="' + row.id + '">' +
                           '<i class="ki-duotone ki-eye fs-5 me-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>View Detail</button>';
                }
            }
        ]
    });

    prDt.on('draw', function () { bindRowActions(); });
}

function bindRowActions() {
    document.querySelectorAll('.btn-view-detail').forEach(function (btn) {
        btn.addEventListener('click', function () { openDetailModal(this.dataset.id); });
    });
}

// ─────────────────────────── Modal ────────────────────────────────────────────

function resetModal() {
    ['detail-title','detail-notes','detail-manager-comment','detail-requester','detail-date'].forEach(function (id) {
        var el = document.getElementById(id);
        if (el) el.textContent = '—';
    });
    var ds = document.getElementById('detail-status');
    if (ds) ds.innerHTML = '—';
    document.getElementById('detail-items-tbody').innerHTML = '<tr><td colspan="6" class="text-center text-muted"><div class="spinner-border spinner-border-sm"></div> Loading...</td></tr>';
    var rc = document.getElementById('review-comment'); if (rc) { rc.value = ''; rc.disabled = false; }
    document.getElementById('admin-review-section').style.display = 'none';
    document.getElementById('comment-section').style.display      = 'none';
    document.getElementById('action-separator').style.display     = 'none';
    document.getElementById('po-content').innerHTML      = '<div class="text-center py-8 text-muted"><div class="spinner-border spinner-border-sm me-2"></div> Loading...</div>';
    document.getElementById('invoice-content').innerHTML = '<div class="text-center py-8 text-muted"><div class="spinner-border spinner-border-sm me-2"></div> Loading...</div>';
    document.getElementById('payment-content').innerHTML = '<div class="text-center py-8 text-muted"><div class="spinner-border spinner-border-sm me-2"></div> Loading...</div>';
    document.getElementById('admin-timeline-wrapper').innerHTML = '';
    // Reset to first tab
    var firstTab = document.querySelector('#admin-modal-tabs .nav-link');
    if (firstTab) { new bootstrap.Tab(firstTab).show(); }
}

function openDetailModal(id) {
    currentPrId     = id;
    currentPrStatus = null;

    resetModal();
    new bootstrap.Modal(document.getElementById('modal-pr-detail')).show();

    // Load request detail
    fetch(routes.show + '/' + id, {
        method: 'GET', credentials: 'same-origin',
        headers: csrfHeaders()
    })
    .then(function (r) { return r.json(); })
    .then(function (res) {
        if (!res.success) {
            document.getElementById('detail-items-tbody').innerHTML = '<tr><td colspan="6" class="text-center text-danger">Failed to load detail.</td></tr>';
            return;
        }
        var pr = res.data;
        currentPrStatus = parseInt(pr.status);

        document.getElementById('modal-pr-title').textContent          = pr.title || 'Request Detail';
        document.getElementById('detail-title').textContent            = pr.title           || '—';
        document.getElementById('detail-notes').textContent            = pr.description     || '—';
        document.getElementById('detail-manager-comment').textContent  = pr.managerComment  || '—';
        document.getElementById('detail-requester').textContent        = pr.createdByName   || '—';
        document.getElementById('detail-date').textContent             = pr.requestDate     || '—';
        document.getElementById('detail-status').innerHTML             = getStatusBadge(pr.status);

        var items = pr.items || [];
        var tbody = items.length === 0
            ? '<tr><td colspan="6" class="text-center text-muted">No items</td></tr>'
            : items.map(function (item, i) {
                var total = (item.quantity || 0) * (item.unitPrice || 0);
                return '<tr><td>' + (i + 1) + '</td><td>' + (item.itemName || '—') + '</td>' +
                    '<td>' + (item.quantity || 0) + '</td><td>' + (item.uoM || '—') + '</td>' +
                    '<td>' + formatRupiah(item.unitPrice || 0) + '</td><td>' + formatRupiah(total) + '</td></tr>';
              }).join('');
        document.getElementById('detail-items-tbody').innerHTML = tbody;

        if (currentPrStatus === 2) {
            document.getElementById('action-separator').style.display     = '';
            document.getElementById('comment-section').style.display      = '';
            document.getElementById('admin-review-section').style.display = '';
        }

        // Load sub-tabs
        loadPoTab(id, currentPrStatus);
        loadInvoiceTab(id, currentPrStatus);
        loadPaymentTab(id, currentPrStatus);
        loadTimelineTab(id);
    })
    .catch(function () {
        document.getElementById('detail-items-tbody').innerHTML = '<tr><td colspan="6" class="text-center text-danger">Error loading data.</td></tr>';
    });
}

// ─────────────────────────── PO Tab ───────────────────────────────────────────

function loadPoTab(id, status) {
    var el = document.getElementById('po-content');

    if (status === 4) {
        el.innerHTML = '<div class="text-center py-8">' +
            '<p class="text-gray-600 mb-5">This request has been approved. Generate a Purchase Order to notify the vendor.</p>' +
            '<button class="btn btn-primary" id="btn-place-order">' +
                '<span class="indicator-label"><i class="ki-duotone ki-document fs-4 me-1"><span class="path1"></span><span class="path2"></span></i>Place Order</span>' +
                '<span class="indicator-progress">Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>' +
            '</button></div>';
        document.getElementById('btn-place-order').addEventListener('click', function () { submitPlaceOrder(id); });
        return;
    }

    if (status < 6) {
        el.innerHTML = '<p class="text-muted text-center py-8">Purchase Order not yet generated.</p>';
        return;
    }

    fetch(routes.purchaseOrder + '/' + id + '/purchase-order', {
        method: 'GET', credentials: 'same-origin', headers: csrfHeaders()
    })
    .then(function (r) { return r.json(); })
    .then(function (res) {
        if (!res.success || !res.data) { el.innerHTML = '<p class="text-danger text-center py-5">Failed to load PO.</p>'; return; }
        var po = res.data;
        var html = '<div class="row mb-4">' +
            '<div class="col-md-4"><span class="text-gray-500 fs-7 fw-bold text-uppercase">PO Number</span><p class="fw-bold fs-5 mt-1">' + (po.poNumber || '—') + '</p></div>' +
            '<div class="col-md-4"><span class="text-gray-500 fs-7 fw-bold text-uppercase">Generated At</span><p class="fw-semibold mt-1">' + (po.generatedAt || '—') + '</p></div>' +
            '<div class="col-md-4"><span class="text-gray-500 fs-7 fw-bold text-uppercase">Sent to Vendor</span><p class="mt-1">' +
                (po.sentToVendor ? '<span class="badge badge-success">Yes — ' + (po.sentAt || '') + '</span>' : '<span class="badge badge-warning">Pending</span>') +
            '</p></div></div>';
        if (po.filePath) {
            html += '<div class="mb-4"><a href="' + po.filePath + '" target="_blank" class="btn btn-sm btn-light-primary"><i class="ki-duotone ki-file fs-5 me-1"><span class="path1"></span><span class="path2"></span></i>View PO File</a></div>';
        }
        var items = po.items || [];
        if (items.length) {
            html += '<div class="table-responsive"><table class="table table-bordered table-sm fs-7"><thead class="table-light"><tr class="fw-bold text-uppercase text-gray-600"><th>Item</th><th>UoM</th><th>Qty</th><th>Unit Price</th><th>Total</th></tr></thead><tbody>';
            items.forEach(function (item) {
                html += '<tr><td>' + (item.itemName || '—') + '</td><td>' + (item.uoM || '—') + '</td><td>' + (item.quantity || 0) + '</td><td>' + formatRupiah(item.unitPrice || 0) + '</td><td>' + formatRupiah((item.quantity || 0) * (item.unitPrice || 0)) + '</td></tr>';
            });
            html += '</tbody></table></div>';
        }
        el.innerHTML = html;
    })
    .catch(function () { el.innerHTML = '<p class="text-danger text-center py-5">Error loading PO.</p>'; });
}

function submitPlaceOrder(id) {
    Swal.fire({
        text: 'Generate PO and notify vendor?',
        icon: 'question',
        showCancelButton: true,
        buttonsStyling: false,
        confirmButtonText: 'Yes, place order',
        cancelButtonText: 'Cancel',
        customClass: { confirmButton: 'btn fw-bold btn-primary', cancelButton: 'btn fw-bold btn-active-light-primary' }
    }).then(function (result) {
        if (!result.value) return;
        var btn = document.getElementById('btn-place-order');
        btn.setAttribute('data-kt-indicator', 'on'); btn.disabled = true;

        fetch(routes.placeOrder + '/' + id + '/place-order', {
            method: 'POST', credentials: 'same-origin',
            headers: csrfHeaders({ 'Content-Type': 'application/json' }),
            body: JSON.stringify({})
        })
        .then(function (r) { return r.json(); })
        .then(function (res) {
            btn.removeAttribute('data-kt-indicator'); btn.disabled = false;
            if (res.success) {
                var data = res.data || {};
                showToast('Purchase Order created! PO#: ' + (data.poNumber || '—'), 'success');
                currentPrStatus = 6;
                loadPoTab(id, 6);
                prDt.draw();
            } else {
                showToast(res.message || 'Failed to place order.', 'error');
            }
        })
        .catch(function () {
            btn.removeAttribute('data-kt-indicator'); btn.disabled = false;
            showToast('Network error.', 'error');
        });
    });
}

// ─────────────────────────── Invoice Tab ──────────────────────────────────────

function renderDiscrepancyTable(discrepancies) {
    if (!discrepancies || discrepancies.length === 0) return '';
    var html = '<div class="table-responsive mt-3"><table class="table table-bordered table-sm fs-7">' +
        '<thead class="table-light"><tr class="fw-bold text-uppercase text-gray-600">' +
        '<th>Item</th><th>Ordered Qty</th><th>Received Qty</th><th>Invoiced Qty</th><th>Expected Price</th><th>Invoiced Price</th><th>Issue</th>' +
        '</tr></thead><tbody>';
    discrepancies.forEach(function (d) {
        html += '<tr><td>' + (d.itemName || '—') + '</td>' +
            '<td>' + (d.orderedQuantity || 0) + '</td>' +
            '<td>' + (d.receivedQuantity || 0) + '</td>' +
            '<td>' + (d.invoicedQuantity || 0) + '</td>' +
            '<td>' + formatRupiah(d.expectedUnitPrice || 0) + '</td>' +
            '<td>' + formatRupiah(d.invoicedUnitPrice || 0) + '</td>' +
            '<td><span class="badge badge-danger">' + (d.discrepancyType || '—') + '</span></td></tr>';
    });
    html += '</tbody></table></div>';
    return html;
}

function renderResolveDisputeForm(invoiceId) {
    return '<div class="separator my-4"></div>' +
        '<div class="fw-bold fs-6 mb-3">Resolve Dispute</div>' +
        '<div class="mb-3">' +
            '<label class="fw-semibold fs-7 mb-2">Resolution</label>' +
            '<div class="d-flex gap-4">' +
                '<div class="form-check"><input class="form-check-input" type="radio" name="dispute-resolution" id="res-accept" value="Accept"/>' +
                '<label class="form-check-label" for="res-accept">Accept</label></div>' +
                '<div class="form-check"><input class="form-check-input" type="radio" name="dispute-resolution" id="res-reject" value="Reject"/>' +
                '<label class="form-check-label" for="res-reject">Reject</label></div>' +
            '</div>' +
        '</div>' +
        '<div class="mb-3">' +
            '<label class="required fw-semibold fs-7 mb-2">Note</label>' +
            '<textarea id="dispute-note" rows="3" class="form-control form-control-solid" placeholder="Explain the resolution..."></textarea>' +
            '<div class="invalid-feedback d-block" id="dispute-note-error"></div>' +
        '</div>' +
        '<div class="text-end">' +
            '<button class="btn btn-primary" id="btn-resolve-dispute" data-invoice-id="' + invoiceId + '">' +
                '<span class="indicator-label">Submit Resolution</span>' +
                '<span class="indicator-progress">Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>' +
            '</button>' +
        '</div>';
}

function bindResolveDispute(id) {
    var btn = document.getElementById('btn-resolve-dispute');
    if (!btn) return;
    btn.addEventListener('click', function () {
        var invoiceId  = this.getAttribute('data-invoice-id');
        var resolution = document.querySelector('input[name="dispute-resolution"]:checked');
        var note       = (document.getElementById('dispute-note') || {}).value || '';
        document.getElementById('dispute-note-error').textContent = '';

        if (!resolution) { showToast('Please select a resolution.', 'warning'); return; }
        if (!note.trim()) { document.getElementById('dispute-note-error').textContent = 'Note is required.'; return; }

        btn.setAttribute('data-kt-indicator', 'on'); btn.disabled = true;

        fetch(routes.invoice + '/' + id + '/invoice/dispute/resolve', {
            method: 'PUT', credentials: 'same-origin',
            headers: csrfHeaders({ 'Content-Type': 'application/json' }),
            body: JSON.stringify({ invoiceId: invoiceId, adminUserId: userId, resolution: resolution.value, note: note.trim() })
        })
        .then(function (r) { return r.json(); })
        .then(function (res) {
            btn.removeAttribute('data-kt-indicator'); btn.disabled = false;
            if (res.success) {
                showToast(res.message || 'Dispute resolved.', 'success');
                loadInvoiceTab(id, currentPrStatus);
                prDt.draw();
            } else {
                showToast(res.message || 'Failed to resolve dispute.', 'error');
            }
        })
        .catch(function () {
            btn.removeAttribute('data-kt-indicator'); btn.disabled = false;
            showToast('Network error.', 'error');
        });
    });
}

function renderUploadInvoiceForm() {
    return '<div class="fw-bold fs-5 mb-5">Upload Invoice</div>' +
        '<div class="row mb-4">' +
            '<div class="col-md-6">' +
                '<label class="required fw-semibold fs-7 mb-2">Vendor Invoice Number</label>' +
                '<input type="text" id="inv-number" class="form-control form-control-solid" placeholder="INV-2026-001"/>' +
                '<div class="invalid-feedback d-block" id="inv-number-error"></div>' +
            '</div>' +
            '<div class="col-md-6">' +
                '<label class="required fw-semibold fs-7 mb-2">Vendor Invoice Date</label>' +
                '<input type="date" id="inv-date" class="form-control form-control-solid"/>' +
                '<div class="invalid-feedback d-block" id="inv-date-error"></div>' +
            '</div>' +
        '</div>' +
        '<div class="mb-5">' +
            '<label class="required fw-semibold fs-7 mb-2">Invoice File <span class="text-muted">(PDF only, max 10MB)</span></label>' +
            '<input type="file" id="inv-file" class="form-control form-control-solid" accept=".pdf"/>' +
            '<div class="invalid-feedback d-block" id="inv-file-error"></div>' +
        '</div>' +
        '<div class="text-end">' +
            '<button class="btn btn-primary" id="btn-upload-invoice">' +
                '<span class="indicator-label"><i class="ki-duotone ki-file-up fs-4 me-1"><span class="path1"></span><span class="path2"></span></i>Upload Invoice</span>' +
                '<span class="indicator-progress">Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>' +
            '</button>' +
        '</div>' +
        '<div id="inv-upload-result"></div>';
}

function bindUploadInvoice(id) {
    var btn = document.getElementById('btn-upload-invoice');
    if (!btn) return;
    btn.addEventListener('click', function () {
        ['inv-number-error','inv-date-error','inv-file-error'].forEach(function (eid) {
            document.getElementById(eid).textContent = '';
        });

        var num  = (document.getElementById('inv-number').value || '').trim();
        var date = (document.getElementById('inv-date').value   || '').trim();
        var file = document.getElementById('inv-file').files[0];
        var valid = true;

        if (!num)  { document.getElementById('inv-number-error').textContent = 'Invoice number is required.'; valid = false; }
        if (!date) { document.getElementById('inv-date-error').textContent   = 'Invoice date is required.';   valid = false; }
        if (!file) { document.getElementById('inv-file-error').textContent   = 'Invoice file is required.';   valid = false; }
        if (!valid) return;

        var formData = new FormData();
        formData.append('uploadedByUserId',    userId);
        formData.append('vendorInvoiceNumber', num);
        formData.append('vendorInvoiceDate',   date);
        formData.append('invoiceFile',         file);

        btn.setAttribute('data-kt-indicator', 'on'); btn.disabled = true;

        fetch(routes.invoice + '/' + id + '/invoice', {
            method: 'POST', credentials: 'same-origin',
            headers: { 'X-CSRF-TOKEN': routes.csrf, 'Accept': 'application/json' },
            body: formData
        })
        .then(function (r) { return r.json(); })
        .then(function (res) {
            btn.removeAttribute('data-kt-indicator'); btn.disabled = false;
            if (!res.success) { showToast(res.message || 'Upload failed.', 'error'); return; }
            document.getElementById('inv-file').value = '';
            var data = res.data || {};
            var matched = data.matchingStatus === 'Matched';
            var resultHtml = '<div class="separator my-4"></div>' +
                '<div class="d-flex align-items-center gap-3 mb-3">' +
                    '<span class="fw-bold fs-6">3-Way Match Result:</span>' +
                    (matched
                        ? '<span class="badge badge-success fs-6">Matched ✓</span>'
                        : '<span class="badge badge-danger fs-6">Discrepancy Found ✗</span>') +
                '</div>';
            if (!matched && data.discrepancyDetails) {
                resultHtml += renderDiscrepancyTable(data.discrepancyDetails);
                resultHtml += renderResolveDisputeForm(data.invoiceId);
            }
            document.getElementById('inv-upload-result').innerHTML = resultHtml;
            if (!matched) { bindResolveDispute(id); }
            prDt.draw();
        })
        .catch(function () {
            btn.removeAttribute('data-kt-indicator'); btn.disabled = false;
            showToast('Network error.', 'error');
        });
    });
}

function loadInvoiceTab(id, status) {
    var el = document.getElementById('invoice-content');

    if (status === 7) {
        el.innerHTML = renderUploadInvoiceForm();
        bindUploadInvoice(id);
        return;
    }

    if (status === 9 || status === 10) {
        fetch(routes.invoice + '/' + id + '/invoice', {
            method: 'GET', credentials: 'same-origin', headers: csrfHeaders()
        })
        .then(function (r) { return r.json(); })
        .then(function (res) {
            if (!res.success || !res.data) { el.innerHTML = '<p class="text-danger text-center py-5">Failed to load invoice.</p>'; return; }
            var inv = res.data;
            var matched = inv.matchingStatus === 'Matched';
            var html = '<div class="row mb-4">' +
                '<div class="col-md-4"><span class="text-gray-500 fs-7 fw-bold text-uppercase">Invoice #</span><p class="fw-semibold mt-1">' + (inv.vendorInvoiceNumber || '—') + '</p></div>' +
                '<div class="col-md-4"><span class="text-gray-500 fs-7 fw-bold text-uppercase">Invoice Date</span><p class="fw-semibold mt-1">' + (inv.vendorInvoiceDate || '—') + '</p></div>' +
                '<div class="col-md-4"><span class="text-gray-500 fs-7 fw-bold text-uppercase">Match Status</span><p class="mt-1">' +
                    (matched ? '<span class="badge badge-success">Matched</span>' : '<span class="badge badge-danger">Disputed</span>') +
                '</p></div></div>';
            if (inv.disputeNote) {
                html += '<div class="alert alert-warning mb-4"><strong>Dispute Note:</strong> ' + inv.disputeNote + '</div>';
            }
            if (status === 10 && inv.discrepancyDetails) {
                html += '<div class="fw-bold fs-7 text-uppercase text-gray-600 mb-2">Discrepancies</div>';
                html += renderDiscrepancyTable(inv.discrepancyDetails);
                html += renderResolveDisputeForm(inv.invoiceId);
            }
            el.innerHTML = html;
            if (status === 10) { bindResolveDispute(id); }
        })
        .catch(function () { el.innerHTML = '<p class="text-danger text-center py-5">Error loading invoice.</p>'; });
        return;
    }

    if (status >= 11) {
        fetch(routes.invoice + '/' + id + '/invoice', {
            method: 'GET', credentials: 'same-origin', headers: csrfHeaders()
        })
        .then(function (r) { return r.json(); })
        .then(function (res) {
            if (!res.success || !res.data) { el.innerHTML = '<p class="text-danger text-center py-5">Failed to load invoice.</p>'; return; }
            var inv = res.data;
            el.innerHTML = '<div class="row mb-4">' +
                '<div class="col-md-4"><span class="text-gray-500 fs-7 fw-bold text-uppercase">Invoice #</span><p class="fw-semibold mt-1">' + (inv.vendorInvoiceNumber || '—') + '</p></div>' +
                '<div class="col-md-4"><span class="text-gray-500 fs-7 fw-bold text-uppercase">Invoice Date</span><p class="fw-semibold mt-1">' + (inv.vendorInvoiceDate || '—') + '</p></div>' +
                '<div class="col-md-4"><span class="text-gray-500 fs-7 fw-bold text-uppercase">Verified At</span><p class="fw-semibold mt-1">' + (inv.verifiedAt || '—') + '</p></div></div>' +
                '<div><span class="text-gray-500 fs-7 fw-bold text-uppercase">Match Status</span><p class="mt-1"><span class="badge badge-success">' + (inv.matchingStatus || '—') + '</span></p></div>';
        })
        .catch(function () { el.innerHTML = '<p class="text-danger text-center py-5">Error loading invoice.</p>'; });
        return;
    }

    el.innerHTML = '<p class="text-muted text-center py-8">Invoice not yet available.</p>';
}

// ─────────────────────────── Payment Tab ──────────────────────────────────────

function loadPaymentTab(id, status) {
    var el = document.getElementById('payment-content');

    if (status === 12) {
        fetch(routes.payment + '/' + id + '/payment', {
            method: 'GET', credentials: 'same-origin', headers: csrfHeaders()
        })
        .then(function (r) { return r.json(); })
        .then(function (res) {
            var paymentId = (res.success && res.data) ? res.data.paymentId : '';
            var html = '<div class="fw-bold fs-5 mb-5">Mark Payment as Paid</div>' +
                '<input type="hidden" id="mark-payment-id" value="' + paymentId + '"/>' +
                '<div class="mb-4"><label class="required fw-semibold fs-7 mb-2">Payment Reference</label>' +
                '<input type="text" id="mark-payment-ref" class="form-control form-control-solid" placeholder="TRX-2026-001"/>' +
                '<div class="invalid-feedback d-block" id="mark-payment-ref-error"></div></div>' +
                '<div class="mb-5"><label class="fw-semibold fs-7 mb-2">Payment Proof <span class="text-muted">(PDF/JPG/PNG, optional, max 10MB)</span></label>' +
                '<input type="file" id="mark-payment-proof" class="form-control form-control-solid" accept=".pdf,.jpg,.jpeg,.png"/></div>' +
                '<div class="text-end"><button class="btn btn-success" id="btn-mark-paid">' +
                    '<span class="indicator-label"><i class="ki-duotone ki-check fs-4 me-1"><span class="path1"></span><span class="path2"></span></i>Mark as Paid</span>' +
                    '<span class="indicator-progress">Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>' +
                '</button></div>';
            el.innerHTML = html;
            bindMarkAsPaid(id);
        })
        .catch(function () {
            el.innerHTML = '<p class="text-danger text-center py-5">Error loading payment data.</p>';
        });
        return;
    }

    if (status === 8) {
        fetch(routes.payment + '/' + id + '/payment', {
            method: 'GET', credentials: 'same-origin', headers: csrfHeaders()
        })
        .then(function (r) { return r.json(); })
        .then(function (res) {
            if (!res.success || !res.data) { el.innerHTML = '<p class="text-danger text-center py-5">Failed to load payment.</p>'; return; }
            var p = res.data;
            var html = '<div class="row mb-4">' +
                '<div class="col-md-4"><span class="text-gray-500 fs-7 fw-bold text-uppercase">Approved At</span><p class="fw-semibold mt-1">' + (p.approvedAt || '—') + '</p></div>' +
                '<div class="col-md-4"><span class="text-gray-500 fs-7 fw-bold text-uppercase">Paid At</span><p class="fw-semibold mt-1">' + (p.paidAt || '—') + '</p></div>' +
                '<div class="col-md-4"><span class="text-gray-500 fs-7 fw-bold text-uppercase">Payment Reference</span><p class="fw-semibold mt-1">' + (p.paymentReference || '—') + '</p></div></div>';
            if (p.paymentProofFile) {
                html += '<a href="' + p.paymentProofFile + '" target="_blank" class="btn btn-sm btn-light-success">' +
                    '<i class="ki-duotone ki-file fs-5 me-1"><span class="path1"></span><span class="path2"></span></i>View Payment Proof</a>';
            }
            el.innerHTML = html;
        })
        .catch(function () { el.innerHTML = '<p class="text-danger text-center py-5">Error loading payment.</p>'; });
        return;
    }

    el.innerHTML = '<p class="text-muted text-center py-8">Payment not yet available.</p>';
}

function bindMarkAsPaid(id) {
    var btn = document.getElementById('btn-mark-paid');
    if (!btn) return;
    btn.addEventListener('click', function () {
        document.getElementById('mark-payment-ref-error').textContent = '';
        var paymentId  = document.getElementById('mark-payment-id').value;
        var ref        = (document.getElementById('mark-payment-ref').value || '').trim();
        var proofInput = document.getElementById('mark-payment-proof');

        if (!ref) { document.getElementById('mark-payment-ref-error').textContent = 'Payment reference is required.'; return; }

        var formData = new FormData();
        formData.append('paymentId',        paymentId);
        formData.append('adminUserId',      userId);
        formData.append('paymentReference', ref);
        if (proofInput.files[0]) { formData.append('paymentProofFile', proofInput.files[0]); }

        btn.setAttribute('data-kt-indicator', 'on'); btn.disabled = true;

        fetch(routes.payment + '/' + id + '/payment/mark-paid', {
            method: 'PUT', credentials: 'same-origin',
            headers: { 'X-CSRF-TOKEN': routes.csrf, 'Accept': 'application/json' },
            body: formData
        })
        .then(function (r) { return r.json(); })
        .then(function (res) {
            btn.removeAttribute('data-kt-indicator'); btn.disabled = false;
            if (res.success) {
                proofInput.value = '';
                showToast(res.message || 'Payment marked as paid.', 'success');
                currentPrStatus = 8;
                loadPaymentTab(id, 8);
                prDt.draw();
            } else {
                showToast(res.message || 'Failed.', 'error');
            }
        })
        .catch(function () {
            btn.removeAttribute('data-kt-indicator'); btn.disabled = false;
            showToast('Network error.', 'error');
        });
    });
}

// ─────────────────────────── Timeline Tab ─────────────────────────────────────

function loadTimelineTab(id) {
    var wrapper = document.getElementById('admin-timeline-wrapper');
    wrapper.innerHTML = '<div class="text-center py-5"><div class="spinner-border spinner-border-sm"></div> Loading timeline...</div>';

    fetch('/procurement-requests/' + id + '/timeline', {
        method: 'GET', credentials: 'same-origin', headers: csrfHeaders()
    })
    .then(function (r) { return r.json(); })
    .then(function (res) {
        if (!res.success) { wrapper.innerHTML = '<p class="text-danger text-center py-5">Failed to load timeline.</p>'; return; }
        var entries = res.data || [];
        if (!entries.length) { wrapper.innerHTML = '<p class="text-muted text-center py-5">No timeline entries yet.</p>'; return; }

        var roleIconMap = { staff: 'ki-user', manager: 'ki-check-circle', admin: 'ki-star' };
        function roleIcon(role) {
            var r = (role || '').toLowerCase();
            for (var k in roleIconMap) { if (r.indexOf(k) !== -1) return roleIconMap[k]; }
            return 'ki-information-5';
        }
        function formatDt(iso) {
            if (!iso) return '—';
            var d = new Date(iso);
            var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
            var pad = function(n) { return n < 10 ? '0' + n : n; };
            return pad(d.getDate()) + ' ' + months[d.getMonth()] + ' ' + d.getFullYear() + ', ' + pad(d.getHours()) + ':' + pad(d.getMinutes());
        }
        function metaChips(meta) {
            if (!meta) return '';
            return '<div class="mt-1">' + Object.keys(meta).map(function(k) {
                return '<span class="badge badge-light-secondary me-1">' + k + ': ' + meta[k] + '</span>';
            }).join('') + '</div>';
        }

        var html = '<div class="timeline">';
        entries.forEach(function (e, i) {
            var icon   = roleIcon(e.actorRole || '');
            var status = e.fromStatus ? (e.fromStatus + ' → ' + e.toStatus) : e.toStatus;
            html += '<div class="timeline-item' + (i < entries.length - 1 ? ' mb-7' : '') + '">' +
                '<div class="timeline-line w-40px"></div>' +
                '<div class="timeline-icon symbol symbol-circle symbol-40px">' +
                    '<div class="symbol-label bg-light">' +
                        '<i class="ki-duotone ' + icon + ' fs-2 text-gray-500"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>' +
                    '</div>' +
                '</div>' +
                '<div class="timeline-content mb-10 mt-n1"><div class="pe-3 mb-2">' +
                    '<div class="fs-6 fw-semibold mb-1">' + (e.action || '—') + '</div>' +
                    '<div class="d-flex align-items-center gap-2 mb-1">' +
                        '<span class="badge badge-light fs-8">' + (e.actorName || '—') + '</span>' +
                        '<span class="badge badge-light-primary fs-8">' + (e.actorRole || '—') + '</span>' +
                    '</div>' +
                    '<div class="text-muted fs-8 mb-1">' + formatDt(e.occurredAt) + '</div>' +
                    '<div class="text-muted fs-8 fst-italic mb-1">' + status + '</div>' +
                    (e.comment ? '<div class="fs-8 fst-italic text-gray-600">"' + e.comment + '"</div>' : '') +
                    metaChips(e.metadata) +
                '</div></div></div>';
        });
        html += '</div>';
        wrapper.innerHTML = html;
    })
    .catch(function () { wrapper.innerHTML = '<p class="text-danger text-center py-5">Error loading timeline.</p>'; });
}

// ─────────────────────────── Admin Review ─────────────────────────────────────

function setReviewButtonsLoading(loading) {
    ['btn-approve', 'btn-reject'].forEach(function (id) {
        var btn = document.getElementById(id);
        if (!btn) return;
        if (loading) { btn.setAttribute('data-kt-indicator', 'on'); btn.disabled = true; }
        else         { btn.removeAttribute('data-kt-indicator');     btn.disabled = false; }
    });
}

function submitAdminReview(status) {
    if (!currentPrId) return;
    var comment   = (document.getElementById('review-comment') || {}).value || '';
    var isApprove = status === 'ApproveByAdmin';
    setReviewButtonsLoading(true);

    fetch(routes.adminReview + '/' + currentPrId + '/admin-review', {
        method: 'PUT', credentials: 'same-origin',
        headers: csrfHeaders({ 'Content-Type': 'application/json' }),
        body: JSON.stringify({ isApproved: isApprove, comment: comment.trim(), adminUserId: userId })
    })
    .then(function (r) { return r.json(); })
    .then(function (res) {
        setReviewButtonsLoading(false);
        bootstrap.Modal.getInstance(document.getElementById('modal-pr-detail')).hide();
        Swal.fire({
            text: res.message || 'Review submitted.',
            icon: 'success',
            buttonsStyling: false,
            confirmButtonText: 'Ok, got it!',
            customClass: { confirmButton: 'btn fw-bold btn-primary' }
        }).then(function () { prDt.draw(); });
    })
    .catch(function () {
        setReviewButtonsLoading(false);
        showToast('Network error.', 'error');
    });
}

// ─────────────────────────── Init ─────────────────────────────────────────────

KTUtil.onDOMContentLoaded(function () {
    initDatatable();

    document.getElementById('pr-search').addEventListener('keyup', function (e) {
        prDt.search(e.target.value).draw();
    });

    document.getElementById('btn-approve').addEventListener('click', function () {
        submitAdminReview('ApproveByAdmin');
    });

    document.getElementById('btn-reject').addEventListener('click', function () {
        Swal.fire({
            text: 'Are you sure you want to reject this request?',
            icon: 'warning',
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonText: 'Yes, reject',
            cancelButtonText: 'Cancel',
            customClass: { confirmButton: 'btn fw-bold btn-danger', cancelButton: 'btn fw-bold btn-active-light-primary' }
        }).then(function (result) {
            if (result.value) submitAdminReview('RejectByAdmin');
        });
    });

    // Reset modal on close so next open starts fresh
    document.getElementById('modal-pr-detail').addEventListener('hidden.bs.modal', function () {
        currentPrId     = null;
        currentPrStatus = null;
    });
});
</script>
@endpush
