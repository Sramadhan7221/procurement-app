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
                        <table id="kt_datatable_pr_manager" class="table align-middle table-row-dashed fs-6 gy-5">
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
                    <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x fs-6 px-5 pt-3" id="manager-modal-tabs">
                        <li class="nav-item">
                            <a class="nav-link active fw-semibold" data-bs-toggle="tab" href="#mgr-tab-detail">Request</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-semibold" data-bs-toggle="tab" href="#mgr-tab-invoice">Invoice Verification</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-semibold" data-bs-toggle="tab" href="#mgr-tab-payment">Payment Approval</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-semibold" data-bs-toggle="tab" href="#mgr-tab-timeline">Timeline</a>
                        </li>
                    </ul>
                    <!--end::Tabs-->

                    <div class="tab-content px-5 py-5">
                        <!--begin::TAB 1 — Request Detail-->
                        <div class="tab-pane fade show active" id="mgr-tab-detail">
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

                            <!--begin::Manager review (status = 1)-->
                            <div id="review-section">
                                <div class="separator mb-5"></div>
                                <div class="mb-5">
                                    <label class="fw-semibold fs-6 mb-2">Comment <span class="text-muted fs-7">(optional)</span></label>
                                    <textarea id="review-comment" rows="3" class="form-control form-control-solid" placeholder="Enter your review comment..."></textarea>
                                </div>
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
                            <!--end::Manager review-->
                        </div>
                        <!--end::TAB 1-->

                        <!--begin::TAB 2 — Invoice Verification-->
                        <div class="tab-pane fade" id="mgr-tab-invoice">
                            <div id="mgr-invoice-content">
                                <div class="text-center py-8 text-muted">
                                    <div class="spinner-border spinner-border-sm me-2"></div> Loading...
                                </div>
                            </div>
                        </div>
                        <!--end::TAB 2-->

                        <!--begin::TAB 3 — Payment Approval-->
                        <div class="tab-pane fade" id="mgr-tab-payment">
                            <div id="mgr-payment-content">
                                <div class="text-center py-8 text-muted">
                                    <div class="spinner-border spinner-border-sm me-2"></div> Loading...
                                </div>
                            </div>
                        </div>
                        <!--end::TAB 3-->

                        <!--begin::TAB 4 — Timeline-->
                        <div class="tab-pane fade" id="mgr-tab-timeline">
                            <div id="mgr-timeline-wrapper"></div>
                        </div>
                        <!--end::TAB 4-->
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
var userId  = document.querySelector('meta[name="user-id"]') ? document.querySelector('meta[name="user-id"]').content : '';

var routes = {
    datatable:     "{{ route('procurement-request.datatable') }}",
    show:          baseUrl,
    managerReview: baseUrl,
    invoice:       baseUrl,
    payment:       baseUrl,
    csrf:          "{{ csrf_token() }}"
};

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
        text: msg, icon: type || 'success',
        buttonsStyling: false, confirmButtonText: 'Ok, got it!',
        customClass: { confirmButton: 'btn fw-bold btn-primary' }
    });
}

// ─────────────────────────── Datatable ────────────────────────────────────────

function initDatatable() {
    prDt = $('#kt_datatable_pr_manager').DataTable({
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
                    draw:    d.draw, start: d.start, length: d.length,
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
    ['detail-title','detail-notes','detail-requester','detail-date'].forEach(function (id) {
        var el = document.getElementById(id); if (el) el.textContent = '—';
    });
    var ds = document.getElementById('detail-status'); if (ds) ds.innerHTML = '—';
    document.getElementById('detail-items-tbody').innerHTML = '<tr><td colspan="6" class="text-center text-muted"><div class="spinner-border spinner-border-sm"></div> Loading...</td></tr>';
    document.getElementById('review-section').style.display  = 'none';
    var rc = document.getElementById('review-comment'); if (rc) rc.value = '';
    document.getElementById('mgr-invoice-content').innerHTML = '<div class="text-center py-8 text-muted"><div class="spinner-border spinner-border-sm me-2"></div> Loading...</div>';
    document.getElementById('mgr-payment-content').innerHTML = '<div class="text-center py-8 text-muted"><div class="spinner-border spinner-border-sm me-2"></div> Loading...</div>';
    document.getElementById('mgr-timeline-wrapper').innerHTML = '';
    var firstTab = document.querySelector('#manager-modal-tabs .nav-link');
    if (firstTab) { new bootstrap.Tab(firstTab).show(); }
}

function openDetailModal(id) {
    currentPrId     = id;
    currentPrStatus = null;
    resetModal();
    new bootstrap.Modal(document.getElementById('modal-pr-detail')).show();

    fetch(routes.show + '/' + id, {
        method: 'GET', credentials: 'same-origin', headers: csrfHeaders()
    })
    .then(function (r) { return r.json(); })
    .then(function (res) {
        if (!res.success) {
            document.getElementById('detail-items-tbody').innerHTML = '<tr><td colspan="6" class="text-center text-danger">Failed to load detail.</td></tr>';
            return;
        }
        var pr = res.data;
        currentPrStatus = parseInt(pr.status);

        document.getElementById('modal-pr-title').textContent   = pr.title || 'Request Detail';
        document.getElementById('detail-title').textContent     = pr.title           || '—';
        document.getElementById('detail-notes').textContent     = pr.description     || '—';
        document.getElementById('detail-requester').textContent = pr.createdByName   || '—';
        document.getElementById('detail-date').textContent      = pr.requestDate     || '—';
        document.getElementById('detail-status').innerHTML      = getStatusBadge(pr.status);

        var items = pr.items || [];
        document.getElementById('detail-items-tbody').innerHTML = items.length === 0
            ? '<tr><td colspan="6" class="text-center text-muted">No items</td></tr>'
            : items.map(function (item, i) {
                var total = (item.quantity || 0) * (item.unitPrice || 0);
                return '<tr><td>' + (i + 1) + '</td><td>' + (item.itemName || '—') + '</td>' +
                    '<td>' + (item.quantity || 0) + '</td><td>' + (item.uoM || '—') + '</td>' +
                    '<td>' + formatRupiah(item.unitPrice || 0) + '</td><td>' + formatRupiah(total) + '</td></tr>';
              }).join('');

        if (currentPrStatus === 1) {
            document.getElementById('review-section').style.display = '';
        }

        loadMgrInvoiceTab(id, currentPrStatus);
        loadMgrPaymentTab(id, currentPrStatus);
        loadMgrTimelineTab(id);
    })
    .catch(function () {
        document.getElementById('detail-items-tbody').innerHTML = '<tr><td colspan="6" class="text-center text-danger">Error loading data.</td></tr>';
    });
}

// ─────────────────────────── Invoice Verification Tab ─────────────────────────

function renderDiscrepancyTable(discrepancies) {
    if (!discrepancies || !discrepancies.length) return '';
    var html = '<div class="table-responsive mt-3"><table class="table table-bordered table-sm fs-7">' +
        '<thead class="table-light"><tr class="fw-bold text-uppercase text-gray-600">' +
        '<th>Item</th><th>Ordered Qty</th><th>Received Qty</th><th>Invoiced Qty</th><th>Expected Price</th><th>Invoiced Price</th><th>Issue</th>' +
        '</tr></thead><tbody>';
    discrepancies.forEach(function (d) {
        html += '<tr><td>' + (d.itemName || '—') + '</td><td>' + (d.orderedQuantity || 0) + '</td>' +
            '<td>' + (d.receivedQuantity || 0) + '</td><td>' + (d.invoicedQuantity || 0) + '</td>' +
            '<td>' + formatRupiah(d.expectedUnitPrice || 0) + '</td><td>' + formatRupiah(d.invoicedUnitPrice || 0) + '</td>' +
            '<td><span class="badge badge-danger">' + (d.discrepancyType || '—') + '</span></td></tr>';
    });
    return html + '</tbody></table></div>';
}

function loadMgrInvoiceTab(id, status) {
    var el = document.getElementById('mgr-invoice-content');

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
                '<div class="col-md-4"><span class="text-gray-500 fs-7 fw-bold text-uppercase">Uploaded At</span><p class="fw-semibold mt-1">' + (inv.uploadedAt || '—') + '</p></div></div>' +
                '<div class="d-flex align-items-center gap-3 mb-4">' +
                    '<span class="fw-bold fs-6">3-Way Match Result:</span>' +
                    (matched
                        ? '<span class="badge badge-success fs-6">Matched ✓</span>'
                        : '<span class="badge badge-danger fs-6">Discrepancy Found ✗</span>') +
                '</div>';

            if (!matched) {
                html += renderDiscrepancyTable(inv.discrepancyDetails);
                html += '<div class="alert alert-warning mt-3"><i class="ki-duotone ki-information-5 me-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>' +
                    'Awaiting admin dispute resolution before invoice can be verified.</div>';
            } else {
                html += '<div class="text-end mt-4">' +
                    '<button class="btn btn-primary" id="btn-verify-invoice" data-invoice-id="' + (inv.invoiceId || '') + '">' +
                        '<span class="indicator-label"><i class="ki-duotone ki-check-circle fs-4 me-1"><span class="path1"></span><span class="path2"></span></i>Verify Invoice</span>' +
                        '<span class="indicator-progress">Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>' +
                    '</button></div>';
            }
            el.innerHTML = html;
            if (matched) { bindVerifyInvoice(id); }
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
                '<span class="badge badge-success">Invoice Verified</span>';
        })
        .catch(function () { el.innerHTML = '<p class="text-danger text-center py-5">Error loading invoice.</p>'; });
        return;
    }

    el.innerHTML = '<p class="text-muted text-center py-8">Invoice not yet available for verification.</p>';
}

function bindVerifyInvoice(id) {
    var btn = document.getElementById('btn-verify-invoice');
    if (!btn) return;
    btn.addEventListener('click', function () {
        var invoiceId = this.getAttribute('data-invoice-id');
        btn.setAttribute('data-kt-indicator', 'on'); btn.disabled = true;

        fetch(routes.invoice + '/' + id + '/invoice/verify', {
            method: 'PUT', credentials: 'same-origin',
            headers: csrfHeaders({ 'Content-Type': 'application/json' }),
            body: JSON.stringify({ invoiceId: invoiceId, managerUserId: userId })
        })
        .then(function (r) { return r.json(); })
        .then(function (res) {
            btn.removeAttribute('data-kt-indicator'); btn.disabled = false;
            if (res.success) {
                showToast(res.message || 'Invoice verified.', 'success');
                currentPrStatus = 11;
                loadMgrInvoiceTab(id, 11);
                loadMgrPaymentTab(id, 11);
                prDt.draw();
            } else {
                showToast(res.message || 'Failed to verify invoice.', 'error');
            }
        })
        .catch(function () {
            btn.removeAttribute('data-kt-indicator'); btn.disabled = false;
            showToast('Network error.', 'error');
        });
    });
}

// ─────────────────────────── Payment Approval Tab ─────────────────────────────

function loadMgrPaymentTab(id, status) {
    var el = document.getElementById('mgr-payment-content');

    if (status === 11) {
        fetch(routes.invoice + '/' + id + '/invoice', {
            method: 'GET', credentials: 'same-origin', headers: csrfHeaders()
        })
        .then(function (r) { return r.json(); })
        .then(function (res) {
            var inv = (res.success && res.data) ? res.data : {};
            var html = '<div class="card bg-light-success border-0 mb-5 p-4">' +
                '<div class="fw-bold fs-6 mb-2">Invoice Verified — Ready for Payment</div>' +
                '<div class="row">' +
                    '<div class="col-md-4"><span class="text-gray-500 fs-7 fw-bold text-uppercase">Invoice #</span><p class="fw-semibold mt-1">' + (inv.vendorInvoiceNumber || '—') + '</p></div>' +
                    '<div class="col-md-4"><span class="text-gray-500 fs-7 fw-bold text-uppercase">Invoice Date</span><p class="fw-semibold mt-1">' + (inv.vendorInvoiceDate || '—') + '</p></div>' +
                    '<div class="col-md-4"><span class="text-gray-500 fs-7 fw-bold text-uppercase">Verified At</span><p class="fw-semibold mt-1">' + (inv.verifiedAt || '—') + '</p></div>' +
                '</div></div>' +
                '<input type="hidden" id="mgr-invoice-id" value="' + (inv.invoiceId || '') + '"/>' +
                '<div class="text-end">' +
                    '<button class="btn btn-success" id="btn-approve-payment">' +
                        '<span class="indicator-label"><i class="ki-duotone ki-check-circle fs-4 me-1"><span class="path1"></span><span class="path2"></span></i>Approve Payment</span>' +
                        '<span class="indicator-progress">Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>' +
                    '</button>' +
                '</div>';
            el.innerHTML = html;
            bindApprovePayment(id);
        })
        .catch(function () { el.innerHTML = '<p class="text-danger text-center py-5">Error loading data.</p>'; });
        return;
    }

    if (status >= 12) {
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

    el.innerHTML = '<p class="text-muted text-center py-8">Payment approval not yet available.</p>';
}

function bindApprovePayment(id) {
    var btn = document.getElementById('btn-approve-payment');
    if (!btn) return;
    btn.addEventListener('click', function () {
        var invoiceId = document.getElementById('mgr-invoice-id').value;
        Swal.fire({
            text: 'Approve this invoice for payment?',
            icon: 'question',
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonText: 'Yes, approve',
            cancelButtonText: 'Cancel',
            customClass: { confirmButton: 'btn fw-bold btn-success', cancelButton: 'btn fw-bold btn-active-light-primary' }
        }).then(function (result) {
            if (!result.value) return;
            btn.setAttribute('data-kt-indicator', 'on'); btn.disabled = true;

            fetch(routes.payment + '/' + id + '/payment/approve', {
                method: 'POST', credentials: 'same-origin',
                headers: csrfHeaders({ 'Content-Type': 'application/json' }),
                body: JSON.stringify({ invoiceId: invoiceId, managerUserId: userId })
            })
            .then(function (r) { return r.json(); })
            .then(function (res) {
                btn.removeAttribute('data-kt-indicator'); btn.disabled = false;
                if (res.success) {
                    showToast(res.message || 'Payment approved.', 'success');
                    currentPrStatus = 12;
                    loadMgrPaymentTab(id, 12);
                    prDt.draw();
                } else {
                    showToast(res.message || 'Failed to approve payment.', 'error');
                }
            })
            .catch(function () {
                btn.removeAttribute('data-kt-indicator'); btn.disabled = false;
                showToast('Network error.', 'error');
            });
        });
    });
}

// ─────────────────────────── Timeline Tab ─────────────────────────────────────

function loadMgrTimelineTab(id) {
    var wrapper = document.getElementById('mgr-timeline-wrapper');
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

// ─────────────────────────── Manager Review ───────────────────────────────────

function submitReview(status) {
    if (!currentPrId) return;
    var comment   = (document.getElementById('review-comment') || {}).value || '';
    var btnId     = status === 'ApproveByManager' ? 'btn-approve' : 'btn-reject';
    var $btn      = document.getElementById(btnId);
    var isApprove = btnId === 'btn-approve';

    $btn.setAttribute('data-kt-indicator', 'on'); $btn.disabled = true;
    document.getElementById(status === 'ApproveByManager' ? 'btn-reject' : 'btn-approve').disabled = true;

    fetch(routes.managerReview + '/' + currentPrId + '/manager-review', {
        method: 'PUT', credentials: 'same-origin',
        headers: csrfHeaders({ 'Content-Type': 'application/json' }),
        body: JSON.stringify({ isApproved: isApprove, comment: comment.trim(), managerUserId: userId })
    })
    .then(function (r) { return r.json(); })
    .then(function (res) {
        $btn.removeAttribute('data-kt-indicator'); $btn.disabled = false;
        document.getElementById(status === 'ApproveByManager' ? 'btn-reject' : 'btn-approve').disabled = false;
        bootstrap.Modal.getInstance(document.getElementById('modal-pr-detail')).hide();
        Swal.fire({
            text: res.message || 'Review submitted.',
            icon: 'success',
            buttonsStyling: false, confirmButtonText: 'Ok, got it!',
            customClass: { confirmButton: 'btn fw-bold btn-primary' }
        }).then(function () { prDt.draw(); });
    })
    .catch(function () {
        $btn.removeAttribute('data-kt-indicator'); $btn.disabled = false;
        document.getElementById(status === 'ApproveByManager' ? 'btn-reject' : 'btn-approve').disabled = false;
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
        submitReview('ApproveByManager');
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
            if (result.value) submitReview('RejectByManager');
        });
    });

    document.getElementById('modal-pr-detail').addEventListener('hidden.bs.modal', function () {
        currentPrId     = null;
        currentPrStatus = null;
    });
});
</script>
@endpush
