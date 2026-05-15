<?php

namespace App\Http\Controllers;

use App\Services\ProcurementInvoiceService;
use Illuminate\Http\Request;

class ProcurementInvoiceController extends Controller
{
    public function __construct(private ProcurementInvoiceService $service) {}

    public function placeOrder(Request $request, string $id)
    {
        $request->validate([
            'adminUserId' => 'required|string',
        ]);

        $result = $this->service->placeOrder($id, $request->only(['adminUserId']));

        return response()->json([
            'success' => $result->success,
            'message' => $result->success ? 'Purchase order placed successfully.' : $result->message,
            'data'    => $result->data,
        ], $result->statusCode);
    }

    public function confirmGoodsReceipt(Request $request, string $id)
    {
        $request->validate([
            'receivedByUserId'  => 'required|string',
            'notes'             => 'nullable|string',
            'items'             => 'required|string',
            'deliveryOrderFile' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);

        $data = [
            'receivedByUserId' => $request->input('receivedByUserId'),
            'notes'            => $request->input('notes', ''),
            'items'            => json_decode($request->input('items'), true) ?? [],
        ];

        $result = $this->service->confirmGoodsReceipt($id, $data, $request->file('deliveryOrderFile'));

        return response()->json([
            'success' => $result->success,
            'message' => $result->success ? 'Goods receipt confirmed successfully.' : $result->message,
            'data'    => $result->data,
        ], $result->statusCode);
    }

    public function uploadInvoice(Request $request, string $id)
    {
        $request->validate([
            'uploadedByUserId'    => 'required|string',
            'vendorInvoiceNumber' => 'required|string',
            'vendorInvoiceDate'   => 'required|date_format:Y-m-d',
            'invoiceFile'         => 'required|file|mimes:pdf|max:10240',
            'items'               => 'required|string',
        ]);

        $data = [
            'uploadedByUserId'    => $request->input('uploadedByUserId'),
            'vendorInvoiceNumber' => $request->input('vendorInvoiceNumber'),
            'vendorInvoiceDate'   => $request->input('vendorInvoiceDate'),
            'items'               => json_decode($request->input('items'), true) ?? [],
        ];

        $result = $this->service->uploadInvoice($id, $data, $request->file('invoiceFile'));

        return response()->json([
            'success' => $result->success,
            'message' => $result->success ? 'Invoice uploaded successfully.' : $result->message,
            'data'    => $result->data,
        ], $result->statusCode);
    }

    public function resolveDispute(Request $request, string $id)
    {
        $request->validate([
            'invoiceId'   => 'required|string',
            'adminUserId' => 'required|string',
            'resolution'  => 'required|in:Accept,Reject',
            'note'        => 'required|string',
        ]);

        $result = $this->service->resolveDispute($id, $request->only(['invoiceId', 'adminUserId', 'resolution', 'note']));

        return response()->json([
            'success' => $result->success,
            'message' => $result->success ? 'Dispute resolved successfully.' : $result->message,
            'data'    => $result->data,
        ], $result->statusCode);
    }

    public function verifyInvoice(Request $request, string $id)
    {
        $request->validate([
            'invoiceId'     => 'required|string',
            'managerUserId' => 'required|string',
        ]);

        $result = $this->service->verifyInvoice($id, $request->only(['invoiceId', 'managerUserId']));

        return response()->json([
            'success' => $result->success,
            'message' => $result->success ? 'Invoice verified successfully.' : $result->message,
            'data'    => $result->data,
        ], $result->statusCode);
    }

    public function approvePayment(Request $request, string $id)
    {
        $request->validate([
            'invoiceId'     => 'required|string',
            'managerUserId' => 'required|string',
        ]);

        $result = $this->service->approvePayment($id, $request->only(['invoiceId', 'managerUserId']));

        return response()->json([
            'success' => $result->success,
            'message' => $result->success ? 'Payment approved successfully.' : $result->message,
            'data'    => $result->data,
        ], $result->statusCode);
    }

    public function markAsPaid(Request $request, string $id)
    {
        $request->validate([
            'paymentId'        => 'required|string',
            'adminUserId'      => 'required|string',
            'paymentReference' => 'required|string',
            'paymentProofFile' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);

        $data = [
            'paymentId'        => $request->input('paymentId'),
            'adminUserId'      => $request->input('adminUserId'),
            'paymentReference' => $request->input('paymentReference'),
        ];

        $result = $this->service->markAsPaid($id, $data, $request->file('paymentProofFile'));

        return response()->json([
            'success' => $result->success,
            'message' => $result->success ? 'Payment marked as paid successfully.' : $result->message,
            'data'    => $result->data,
        ], $result->statusCode);
    }

    public function getTimeline(Request $request, string $id)
    {
        $result = $this->service->getTimeline($id);

        return response()->json([
            'success' => $result->success,
            'data'    => $result->data,
            'message' => $result->message,
        ], $result->statusCode);
    }

    public function getPurchaseOrder(Request $request, string $id)
    {
        $result = $this->service->getPurchaseOrder($id);

        return response()->json([
            'success' => $result->success,
            'data'    => $result->data,
            'message' => $result->message,
        ], $result->statusCode);
    }

    public function getGoodsReceipt(Request $request, string $id)
    {
        $result = $this->service->getGoodsReceipt($id);

        return response()->json([
            'success' => $result->success,
            'data'    => $result->data,
            'message' => $result->message,
        ], $result->statusCode);
    }

    public function getInvoiceDetail(Request $request, string $id)
    {
        $result = $this->service->getInvoiceDetail($id);

        return response()->json([
            'success' => $result->success,
            'data'    => $result->data,
            'message' => $result->message,
        ], $result->statusCode);
    }

    public function getPaymentDetail(Request $request, string $id)
    {
        $result = $this->service->getPaymentDetail($id);

        return response()->json([
            'success' => $result->success,
            'data'    => $result->data,
            'message' => $result->message,
        ], $result->statusCode);
    }
}
