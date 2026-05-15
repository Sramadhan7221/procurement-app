<?php

namespace App\Services;

use App\Constants\ApiUrl;
use App\DTOs\ApiResponse;
use Illuminate\Http\UploadedFile;

class ProcurementInvoiceService
{
    public function __construct(private ApiClient $client) {}

    private function prPath(string $id, string $suffix = ''): string
    {
        return ApiUrl::PROCUREMENT_REQUESTS->value . '/' . $id . $suffix;
    }

    public function placeOrder(string $id, array $data): ApiResponse
    {
        // API expects: { "AdminUserId": "uuid" }
        // Ref: PlaceOrderCommand.cs — ProcurementId injected from route by .NET controller
        return $this->client->post($this->prPath($id, ApiUrl::PROCUREMENT_PLACE_ORDER_SUFFIX->value), [
            'AdminUserId' => $data['adminUserId'],
        ]);
    }

    public function confirmGoodsReceipt(string $id, array $data, ?UploadedFile $deliveryOrderFile): ApiResponse
    {
        // API expects (multipart): ReceivedByUserId, Notes, Items[n].ProcurementItemId,
        // Items[n].ReceivedQuantity, DeliveryOrderFile (optional)
        // Ref: ConfirmGoodsReceiptCommand.cs — [FromForm], ProcurementId from route
        $formData = [
            'ReceivedByUserId' => $data['receivedByUserId'],
            'Notes'            => $data['notes'] ?? '',
        ];

        foreach (($data['items'] ?? []) as $i => $item) {
            $formData["Items[{$i}].ProcurementItemId"] = $item['procurementItemId'];
            $formData["Items[{$i}].ReceivedQuantity"]  = $item['receivedQuantity'];
        }

        $files = [];
        if ($deliveryOrderFile) {
            $files['DeliveryOrderFile'] = $deliveryOrderFile;
        }
        return $this->client->postMultipart(
            $this->prPath($id, ApiUrl::PROCUREMENT_GOODS_RECEIPT_SUFFIX->value),
            $formData,
            $files
        );
    }

    public function uploadInvoice(string $id, array $data, UploadedFile $invoiceFile): ApiResponse
    {
        // API expects (multipart): UploadedByUserId, VendorInvoiceNumber, VendorInvoiceDate,
        // InvoiceFile, Items[n].ProcurementItemId, Items[n].InvoicedQuantity, Items[n].InvoiceUnitPrice
        // Ref: UploadInvoiceCommand.cs — [FromForm], ProcurementId from route
        $formData = [
            'UploadedByUserId'    => $data['uploadedByUserId'],
            'VendorInvoiceNumber' => $data['vendorInvoiceNumber'],
            'VendorInvoiceDate'   => $data['vendorInvoiceDate'],
        ];

        foreach (($data['items'] ?? []) as $i => $item) {
            $formData["Items[{$i}].ProcurementItemId"] = $item['procurementItemId'];
            $formData["Items[{$i}].InvoicedQuantity"]  = $item['invoicedQuantity'];
            $formData["Items[{$i}].InvoiceUnitPrice"]  = $item['invoiceUnitPrice'];
        }

        return $this->client->postMultipart(
            $this->prPath($id, ApiUrl::PROCUREMENT_INVOICE_SUFFIX->value),
            $formData,
            ['InvoiceFile' => $invoiceFile]
        );
    }

    public function resolveDispute(string $id, array $data): ApiResponse
    {
        // API expects: { "InvoiceId": "uuid", "AdminUserId": "uuid", "Resolution": 0|1, "Note": "string" }
        // Ref: ResolveInvoiceDisputeCommand.cs — DisputeResolution enum: Accept=0, Reject=1
        $resolutionMap = ['Accept' => 0, 'Reject' => 1];
        return $this->client->put(
            $this->prPath($id, ApiUrl::PROCUREMENT_INVOICE_DISPUTE_RESOLVE_SUFFIX->value),
            [
                'InvoiceId'   => $data['invoiceId'],
                'AdminUserId' => $data['adminUserId'],
                'Resolution'  => $resolutionMap[$data['resolution']] ?? 0,
                'Note'        => $data['note'] ?? null,
            ]
        );
    }

    public function verifyInvoice(string $id, array $data): ApiResponse
    {
        // API expects: { "InvoiceId": "uuid", "ManagerUserId": "uuid" }
        // Ref: VerifyInvoiceCommand.cs — both fields required
        return $this->client->put(
            $this->prPath($id, ApiUrl::PROCUREMENT_INVOICE_VERIFY_SUFFIX->value),
            [
                'InvoiceId'     => $data['invoiceId'],
                'ManagerUserId' => $data['managerUserId'],
            ]
        );
    }

    public function approvePayment(string $id, array $data): ApiResponse
    {
        // API expects: { "InvoiceId": "uuid", "ManagerUserId": "uuid" }
        // Ref: ApprovePaymentCommand.cs — ProcurementId injected from route, InvoiceId + ManagerUserId required
        return $this->client->post(
            $this->prPath($id, ApiUrl::PROCUREMENT_PAYMENT_APPROVE_SUFFIX->value),
            [
                'InvoiceId'     => $data['invoiceId'],
                'ManagerUserId' => $data['managerUserId'],
            ]
        );
    }

    public function markAsPaid(string $id, array $data, ?UploadedFile $proofFile): ApiResponse
    {
        // API expects (multipart): PaymentId, AdminUserId, PaymentReference, PaymentProofFile (optional)
        // Ref: MarkAsPaidCommand.cs — [FromForm]
        $formData = [
            'PaymentId'        => $data['paymentId'],
            'AdminUserId'      => $data['adminUserId'],
            'PaymentReference' => $data['paymentReference'],
        ];
        $files = [];
        if ($proofFile) {
            $files['PaymentProofFile'] = $proofFile;
        }
        return $this->client->putMultipart(
            $this->prPath($id, ApiUrl::PROCUREMENT_PAYMENT_MARK_PAID_SUFFIX->value),
            $formData,
            $files
        );
    }

    public function getTimeline(string $id): ApiResponse
    {
        return $this->client->get($this->prPath($id, ApiUrl::PROCUREMENT_TIMELINE_SUFFIX->value));
    }

    public function getPurchaseOrder(string $id): ApiResponse
    {
        return $this->client->get($this->prPath($id, ApiUrl::PROCUREMENT_PURCHASE_ORDER_SUFFIX->value));
    }

    public function getGoodsReceipt(string $id): ApiResponse
    {
        return $this->client->get($this->prPath($id, ApiUrl::PROCUREMENT_GOODS_RECEIPT_SUFFIX->value));
    }

    public function getInvoiceDetail(string $id): ApiResponse
    {
        return $this->client->get($this->prPath($id, ApiUrl::PROCUREMENT_INVOICE_SUFFIX->value));
    }

    public function getPaymentDetail(string $id): ApiResponse
    {
        return $this->client->get($this->prPath($id, ApiUrl::PROCUREMENT_PAYMENT_SUFFIX->value));
    }
}
