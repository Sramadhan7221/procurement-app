<?php

namespace App\Http\Controllers;

use App\Services\VendorService;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function __construct(private VendorService $vendorService) {}

    public function index()
    {
        return view('pages.vendor', [
            'title' => 'Vendors',
        ]);
    }

    public function datatableAjax(Request $request)
    {
        $params = $request->only(['draw', 'start', 'length', 'search', 'order', 'columns']);
        $result = $this->vendorService->datatable($params);

        if ($result->success) {
            return response()->json($result->data);
        }

        return response()->json(['error' => $result->message], $result->statusCode);
    }

    public function store(Request $request)
    {
        $result = $this->vendorService->create($request->all());

        return response()->json([
            'success' => $result->success,
            'message' => $result->success ? 'Vendor created successfully.' : $result->message,
            'data'    => $result->data,
        ], $result->statusCode);
    }

    public function update(Request $request, string $id)
    {
        $result = $this->vendorService->update($id, $request->all());

        return response()->json([
            'success' => $result->success,
            'message' => $result->success ? 'Vendor updated successfully.' : $result->message,
            'data'    => $result->data,
        ], $result->statusCode);
    }

    public function destroy(string $id)
    {
        $result = $this->vendorService->destroy($id);

        return response()->json([
            'success' => $result->success,
            'message' => $result->success ? 'Vendor deleted successfully.' : $result->message,
        ], $result->statusCode);
    }
}
