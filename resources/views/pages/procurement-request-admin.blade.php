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
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="fw-bold" id="modal-pr-title">Request Detail</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                </div>
                <div class="modal-body px-5 py-7">
                    <!--begin::Detail section-->
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
                                        <th>#</th>
                                        <th>Item Name</th>
                                        <th>Qty</th>
                                        <th>Unit</th>
                                        <th>Unit Price</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody id="detail-items-tbody">
                                    <tr><td colspan="6" class="text-center text-muted">No items</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!--end::Items-->

                    <!--begin::Comment input (shared)-->
                    <div class="separator mb-5" id="action-separator" style="display:none;"></div>
                    <div id="comment-section" style="display:none;">
                        <div class="mb-5">
                            <label class="fw-semibold fs-6 mb-2">Comment <span class="text-muted fs-7">(optional)</span></label>
                            <textarea id="review-comment" rows="3" class="form-control form-control-solid" placeholder="Enter your comment..."></textarea>
                        </div>
                    </div>
                    <!--end::Comment input-->

                    <!--begin::Admin review actions (status = 2)-->
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
                    <!--end::Admin review actions-->

                    <!--begin::Progress action (status in 4,6,7)-->
                    {{-- <div id="admin-progress-section" style="display:none;">
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-primary" id="btn-progress">
                                <span class="indicator-label" id="btn-progress-label">Advance</span>
                                <span class="indicator-progress">Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                        </div>
                    </div> --}}
                    <!--end::Progress action-->
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

var routes = {
    datatable:   "{{ route('procurement-request.datatable') }}",
    show:        "{{ url('procurement-requests') }}",
    adminReview: "{{ url('procurement-requests') }}",
    progress:    "{{ url('procurement-requests') }}",
    csrf:        "{{ csrf_token() }}"
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

// Maps current status → next status value for progress
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
            {
                targets: 3,
                render: function (data) { return getStatusBadge(data); }
            },
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

function openDetailModal(id) {
    currentPrId     = id;
    currentPrStatus = null;

    // Reset modal
    document.getElementById('detail-title').textContent          = '—';
    document.getElementById('detail-notes').textContent          = '—';
    document.getElementById('detail-manager-comment').textContent = '—';
    document.getElementById('detail-requester').textContent      = '—';
    document.getElementById('detail-date').textContent           = '—';
    document.getElementById('detail-status').innerHTML           = '—';
    document.getElementById('detail-items-tbody').innerHTML      = '<tr><td colspan="6" class="text-center text-muted"><div class="spinner-border spinner-border-sm"></div> Loading...</td></tr>';
    document.getElementById('review-comment').value              = '';
    document.getElementById('admin-review-section').style.display  = 'none';
    // document.getElementById('admin-progress-section').style.display = 'none';
    document.getElementById('comment-section').style.display       = 'none';
    document.getElementById('action-separator').style.display      = 'none';

    new bootstrap.Modal(document.getElementById('modal-pr-detail')).show();

    $.ajax({
        url:     routes.show + '/' + id,
        type:    'GET',
        headers: { 'X-CSRF-TOKEN': routes.csrf, 'Accept': 'application/json' },
        success: function (res) {
            if (!res.success) {
                document.getElementById('detail-items-tbody').innerHTML = '<tr><td colspan="6" class="text-center text-danger">Failed to load detail.</td></tr>';
                return;
            }
            var pr = res.data;
            currentPrStatus = parseInt(pr.status);

            document.getElementById('modal-pr-title').textContent         = pr.title || 'Request Detail';
            document.getElementById('detail-title').textContent           = pr.title           || '—';
            document.getElementById('detail-notes').textContent           = pr.description           || '—';
            document.getElementById('detail-manager-comment').textContent = pr.managerComment  || '—';
            document.getElementById('detail-requester').textContent       = pr.createdByName   || '—';
            document.getElementById('detail-date').textContent            = pr.requestDate     || '—';
            document.getElementById('detail-status').innerHTML            = getStatusBadge(pr.status);
            document.getElementById('review-comment').value               = pr.adminComment || "—";

            var items = pr.items || [];
            var tbody = '';
            if (items.length === 0) {
                tbody = '<tr><td colspan="6" class="text-center text-muted">No items</td></tr>';
            } else {
                items.forEach(function (item, i) {
                    var total = (item.quantity || 0) * (item.unitPrice || 0);
                    tbody += '<tr>' +
                        '<td>' + (i + 1) + '</td>' +
                        '<td>' + (item.itemName     || '—') + '</td>' +
                        '<td>' + (item.quantity  || 0)  + '</td>' +
                        '<td>' + (item.uoM      || '—') + '</td>' +
                        '<td>' + formatRupiah(item.unitPrice || 0) + '</td>' +
                        '<td>' + formatRupiah(total) + '</td>' +
                    '</tr>';
                });
            }
            document.getElementById('detail-items-tbody').innerHTML = tbody;

            // Show admin review buttons if status = ApproveByManager (2)
            if (currentPrStatus === 2) {
                document.getElementById('action-separator').style.display    = '';
                document.getElementById('comment-section').style.display     = '';
                document.getElementById('admin-review-section').style.display = '';
            }

            // Show progress button if status in {4, 6, 7}
            if (progressMap[currentPrStatus]) {
                document.getElementById('review-comment').disabled = true;  
                document.getElementById('action-separator').style.display     = '';
                document.getElementById('comment-section').style.display      = '';
                // document.getElementById('admin-progress-section').style.display = '';
                // document.getElementById('btn-progress-label').textContent     = progressMap[currentPrStatus].label;
            }
        },
        error: function () {
            document.getElementById('detail-items-tbody').innerHTML = '<tr><td colspan="6" class="text-center text-danger">Error loading data.</td></tr>';
        }
    });
}

function setReviewButtonsLoading(loading) {
    ['btn-approve', 'btn-reject'].forEach(function (id) {
        var btn = document.getElementById(id);
        if (loading) { btn.setAttribute('data-kt-indicator', 'on'); btn.disabled = true; }
        else         { btn.removeAttribute('data-kt-indicator');     btn.disabled = false; }
    });
}

function submitAdminReview(status) {
    if (!currentPrId) return;
    var comment = document.getElementById('review-comment').value.trim();
    var isApprove = status === 'ApproveByAdmin';
    setReviewButtonsLoading(true);

    $.ajax({
        url:  routes.adminReview + '/' + currentPrId + '/admin-review',
        type: 'PUT',
        headers: { 'X-CSRF-TOKEN': routes.csrf, 'Accept': 'application/json', 'Content-Type': 'application/json' },
        data: JSON.stringify({ isApproved: isApprove, comment: comment, adminUserId: "{{ session('user_id') }}" }),
        success: function (res) {
            setReviewButtonsLoading(false);
            bootstrap.Modal.getInstance(document.getElementById('modal-pr-detail')).hide();
            Swal.fire({
                text: res.message || 'Review submitted.',
                icon: 'success',
                buttonsStyling: false,
                confirmButtonText: 'Ok, got it!',
                customClass: { confirmButton: 'btn fw-bold btn-primary' }
            }).then(function () { prDt.draw(); });
        },
        error: function (xhr) {
            setReviewButtonsLoading(false);
            var res = xhr.responseJSON || {};
            Swal.fire({ text: res.message || 'Something went wrong.', icon: 'error', buttonsStyling: false, confirmButtonText: 'Ok, got it!', customClass: { confirmButton: 'btn fw-bold btn-primary' } });
        }
    });
}

function submitProgress() {
    if (!currentPrId || !progressMap[currentPrStatus]) return;
    var comment    = document.getElementById('review-comment').value.trim();
    var nextStatus = progressMap[currentPrStatus].nextStatus;
    // var $btn       = document.getElementById('btn-progress');

    $btn.setAttribute('data-kt-indicator', 'on');
    $btn.disabled = true;

    $.ajax({
        url:  routes.progress + '/' + currentPrId + '/progress',
        type: 'PUT',
        headers: { 'X-CSRF-TOKEN': routes.csrf, 'Accept': 'application/json', 'Content-Type': 'application/json' },
        data: JSON.stringify({ newStatus: nextStatus, comment: comment }),
        success: function (res) {
            $btn.removeAttribute('data-kt-indicator');
            $btn.disabled = false;
            bootstrap.Modal.getInstance(document.getElementById('modal-pr-detail')).hide();
            Swal.fire({
                text: res.message || 'Status updated.',
                icon: 'success',
                buttonsStyling: false,
                confirmButtonText: 'Ok, got it!',
                customClass: { confirmButton: 'btn fw-bold btn-primary' }
            }).then(function () { prDt.draw(); });
        },
        error: function (xhr) {
            $btn.removeAttribute('data-kt-indicator');
            $btn.disabled = false;
            var res = xhr.responseJSON || {};
            Swal.fire({ text: res.message || 'Something went wrong.', icon: 'error', buttonsStyling: false, confirmButtonText: 'Ok, got it!', customClass: { confirmButton: 'btn fw-bold btn-primary' } });
        }
    });
}

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

    // document.getElementById('btn-progress').addEventListener('click', function () {
    //     if (!currentPrStatus || !progressMap[currentPrStatus]) return;
    //     Swal.fire({
    //         text: 'Confirm: "' + progressMap[currentPrStatus].label + '"?',
    //         icon: 'question',
    //         showCancelButton: true,
    //         buttonsStyling: false,
    //         confirmButtonText: 'Yes, proceed',
    //         cancelButtonText: 'Cancel',
    //         customClass: { confirmButton: 'btn fw-bold btn-primary', cancelButton: 'btn fw-bold btn-active-light-primary' }
    //     }).then(function (result) {
    //         if (result.value) submitProgress();
    //     });
    // });
});
</script>
@endpush
