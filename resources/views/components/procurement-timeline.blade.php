@props(['procurementId'])

<div class="procurement-timeline-wrapper" data-pr-id="{{ $procurementId }}">
    <!--begin::Skeleton-->
    <div class="timeline-skeleton">
        @for($i = 0; $i < 3; $i++)
        <div class="d-flex gap-4 mb-6">
            <div class="d-flex flex-column align-items-center">
                <div class="bg-light rounded-circle" style="width:36px;height:36px;"></div>
                <div class="bg-light mt-1" style="width:2px;height:40px;"></div>
            </div>
            <div class="flex-grow-1 pt-1">
                <div class="bg-light rounded mb-2" style="height:14px;width:40%;"></div>
                <div class="bg-light rounded mb-1" style="height:12px;width:70%;"></div>
                <div class="bg-light rounded" style="height:12px;width:50%;"></div>
            </div>
        </div>
        @endfor
    </div>
    <!--end::Skeleton-->

    <!--begin::Timeline entries (populated by JS)-->
    <div class="timeline-entries" style="display:none;"></div>
    <!--end::Timeline entries-->

    <!--begin::Error state-->
    <div class="timeline-error text-center text-danger py-5" style="display:none;">
        <i class="ki-duotone ki-information-5 fs-2x mb-2 d-block"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
        Failed to load timeline.
    </div>
    <!--end::Error state-->
</div>

@once
@push('scripts')
<script>
(function () {
    var roleIconMap = {
        staff:   'ki-user',
        manager: 'ki-check-circle',
        admin:   'ki-star',
    };

    function roleIcon(role) {
        var r = (role || '').toLowerCase();
        for (var k in roleIconMap) {
            if (r.indexOf(k) !== -1) return roleIconMap[k];
        }
        return 'ki-information-5';
    }

    function formatDate(iso) {
        if (!iso) return '—';
        var d = new Date(iso);
        var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        var pad = function(n) { return n < 10 ? '0' + n : n; };
        return pad(d.getDate()) + ' ' + months[d.getMonth()] + ' ' + d.getFullYear() +
               ', ' + pad(d.getHours()) + ':' + pad(d.getMinutes());
    }

    function renderMetadata(meta) {
        if (!meta || typeof meta !== 'object') return '';
        var chips = '';
        Object.keys(meta).forEach(function (k) {
            chips += '<span class="badge badge-light-secondary me-1">' +
                     k + ': ' + meta[k] + '</span>';
        });
        return chips ? '<div class="mt-1">' + chips + '</div>' : '';
    }

    function renderTimeline(entries, container) {
        if (!entries || entries.length === 0) {
            container.innerHTML = '<p class="text-muted text-center py-5">No timeline entries yet.</p>';
            return;
        }
        var html = '<div class="timeline">';
        entries.forEach(function (entry, i) {
            var isLast = i === entries.length - 1;
            var icon   = roleIcon(entry.actorRole || '');
            var status = entry.fromStatus
                ? (entry.fromStatus + ' → ' + entry.toStatus)
                : entry.toStatus;
            html += '<div class="timeline-item' + (isLast ? '' : ' mb-7') + '">' +
                '<div class="timeline-line w-40px"></div>' +
                '<div class="timeline-icon symbol symbol-circle symbol-40px">' +
                    '<div class="symbol-label bg-light">' +
                        '<i class="ki-duotone ' + icon + ' fs-2 text-gray-500">' +
                            '<span class="path1"></span><span class="path2"></span><span class="path3"></span>' +
                        '</i>' +
                    '</div>' +
                '</div>' +
                '<div class="timeline-content mb-10 mt-n1">' +
                    '<div class="pe-3 mb-2">' +
                        '<div class="fs-6 fw-semibold mb-1">' + (entry.action || '—') + '</div>' +
                        '<div class="d-flex align-items-center gap-2 mb-1">' +
                            '<span class="badge badge-light fs-8">' + (entry.actorName || '—') + '</span>' +
                            '<span class="badge badge-light-primary fs-8">' + (entry.actorRole || '—') + '</span>' +
                        '</div>' +
                        '<div class="text-muted fs-8 mb-1">' + formatDate(entry.occurredAt) + '</div>' +
                        '<div class="text-muted fs-8 fst-italic mb-1">' + status + '</div>' +
                        (entry.comment ? '<div class="fs-8 fst-italic text-gray-600">"' + entry.comment + '"</div>' : '') +
                        renderMetadata(entry.metadata) +
                    '</div>' +
                '</div>' +
            '</div>';
        });
        html += '</div>';
        container.innerHTML = html;
    }

    function loadTimeline(wrapper) {
        var prId    = wrapper.getAttribute('data-pr-id');
        var skeleton = wrapper.querySelector('.timeline-skeleton');
        var entries  = wrapper.querySelector('.timeline-entries');
        var errEl    = wrapper.querySelector('.timeline-error');

        if (!prId) return;

        skeleton.style.display = '';
        entries.style.display  = 'none';
        errEl.style.display    = 'none';

        fetch('/procurement-requests/' + prId + '/timeline', {
            method:      'GET',
            credentials: 'same-origin',
            headers: {
                'Accept':        'application/json',
                'X-CSRF-TOKEN':  document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(function (r) { return r.json(); })
        .then(function (res) {
            skeleton.style.display = 'none';
            if (res.success) {
                entries.style.display = '';
                renderTimeline(res.data || [], entries);
            } else {
                errEl.style.display = '';
            }
        })
        .catch(function () {
            skeleton.style.display = 'none';
            errEl.style.display    = '';
        });
    }

    // Auto-load on page load for any timeline wrapper on the page
    KTUtil.onDOMContentLoaded(function () {
        document.querySelectorAll('.procurement-timeline-wrapper').forEach(function (w) {
            loadTimeline(w);
        });
    });

    // Expose so modal-based views can trigger reload
    window.loadProcurementTimeline = function (prId) {
        var w = document.querySelector('.procurement-timeline-wrapper[data-pr-id="' + prId + '"]');
        if (w) loadTimeline(w);
    };
})();
</script>
@endpush
@endonce
