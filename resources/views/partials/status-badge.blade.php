@php
$statusMap = [
    1  => ['label' => 'Request Created',   'cls' => 'badge-secondary'],
    2  => ['label' => 'Manager Approved',  'cls' => 'badge-info'],
    3  => ['label' => 'Manager Rejected',  'cls' => 'badge-danger'],
    4  => ['label' => 'Admin Approved',    'cls' => 'badge-primary'],
    5  => ['label' => 'Admin Rejected',    'cls' => 'badge-danger'],
    6  => ['label' => 'In Order',          'cls' => 'badge-warning'],
    7  => ['label' => 'Order Received',    'cls' => 'badge-info'],
    8  => ['label' => 'Completed',         'cls' => 'badge-success'],
    9  => ['label' => 'Invoice Uploaded',  'cls' => 'badge-warning'],
    10 => ['label' => 'Invoice Disputed',  'cls' => 'badge-danger'],
    11 => ['label' => 'Invoice Verified',  'cls' => 'badge-info'],
    12 => ['label' => 'Payment Processed', 'cls' => 'badge-primary'],
];
$s = $statusMap[$status ?? 0] ?? ['label' => 'Unknown', 'cls' => 'badge-light'];
@endphp
<span class="badge {{ $s['cls'] }}">{{ $s['label'] }}</span>
