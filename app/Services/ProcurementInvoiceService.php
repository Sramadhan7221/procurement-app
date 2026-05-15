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

    public function placeOrder(string $id): ApiResponse
    {
        return $this->client->post($this->prPath($id, ApiUrl::PROCUREMENT_PLACE_ORDER_SUFFIX->value));
    }

    public function confirmGoodsReceipt(string $id, array $data, ?UploadedFile $deliveryOrderFile): ApiResponse
    {
        $formData = [
            'receivedByUserId' => $data['receivedByUserId'],
            'notes'            => $data['notes'] ?? '',
            'items'            => json_encode($data['items'] ?? []),
        ];
        $files = [];
        if ($deliveryOrderFile) {
            $files['deliveryOrderFile'] = $deliveryOrderFile;
        }
        return $this->client->postMultipart(
            $this->prPath($id, ApiUrl::PROCUREMENT_GOODS_RECEIPT_SUFFIX->value),
            $formData,
            $files
        );
    }

    public function uploadInvoice(string $id, array $data, UploadedFile $invoiceFile): ApiResponse
    {
        $formData = [
            'uploadedByUserId'    => $data['uploadedByUserId'],
            'vendorInvoiceNumber' => $data['vendorInvoiceNumber'],
            'vendorInvoiceDate'   => $data['vendorInvoiceDate'],
        ];
        return $this->client->postMultipart(
            $this->prPath($id, ApiUrl::PROCUREMENT_INVOICE_SUFFIX->value),
            $formData,
            ['invoiceFile' => $invoiceFile]
        );
    }

    public function resolveDispute(string $id, array $data): ApiResponse
    {
        return $this->client->put(
            $this->prPath($id, ApiUrl::PROCUREMENT_INVOICE_DISPUTE_RESOLVE_SUFFIX->value),
            $data
        );
    }

    public function verifyInvoice(string $id, array $data): ApiResponse
    {
        return $this->client->put(
            $this->prPath($id, ApiUrl::PROCUREMENT_INVOICE_VERIFY_SUFFIX->value),
            $data
        );
    }

    public function approvePayment(string $id, array $data): ApiResponse
    {
        return $this->client->post(
            $this->prPath($id, ApiUrl::PROCUREMENT_PAYMENT_APPROVE_SUFFIX->value),
            $data
        );
    }

    public function markAsPaid(string $id, array $data, ?UploadedFile $proofFile): ApiResponse
    {
        $formData = [
            'paymentId'        => $data['paymentId'],
            'adminUserId'      => $data['adminUserId'],
            'paymentReference' => $data['paymentReference'],
        ];
        $files = [];
        if ($proofFile) {
            $files['paymentProofFile'] = $proofFile;
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
