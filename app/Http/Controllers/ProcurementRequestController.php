<?php

namespace App\Http\Controllers;

use App\Services\ProcurementRequestService;
use Illuminate\Http\Request;

class ProcurementRequestController extends Controller
{
    public function __construct(private ProcurementRequestService $service) {}

    public function staffIndex(Request $request)
    {
        $id = $request->query('id');
        $procurementRequest = null;
        if ($id) {
            $result = $this->service->find($id);
            $procurementRequest = $result->success ? $result->data : null;
        }
        return view('pages.procurement-request-staff', [
            'title'              => 'Procurement Request',
            'procurementRequest' => $procurementRequest,
            'apiUrls'            => [
                'productsDataTable' => route('procurement-request.products-datatable'),
                'categoriesOptions' => route('procurement-request.categories-options'),
            ],
        ]);
    }

    public function staffList()
    {
        return view('pages.procurement-list-request-staff', [
            'title' => 'Procurement Requests List',
        ]);
    }

    public function managerIndex()
    {
        return view('pages.procurement-request-manager', [
            'title' => 'Procurement Requests',
        ]);
    }

    public function adminIndex()
    {
        return view('pages.procurement-request-admin', [
            'title' => 'Procurement Requests',
        ]);
    }

    public function datatableAjax(Request $request)
    {
        $params = $request->only(['draw', 'start', 'length', 'search', 'order', 'columns']);
        $searchValue = $params['search']['value'] ?? '';
        $params['search'] = $searchValue;
        $params['query'] = $searchValue;
        $params['userId'] = session('user_id');
        $result = $this->service->datatable($params);

        if ($result->success) {
            return response()->json($result->data);
        }

        return response()->json(['error' => $result->message], $result->statusCode);
    }

    public function store(Request $request)
    {
        $result = $this->service->create($request->all());

        return response()->json([
            'success' => $result->success,
            'message' => $result->success ? 'Procurement request submitted successfully.' : $result->message,
            'data'    => $result->data,
        ], $result->statusCode);
    }

    public function show(string $id)
    {
        $result = $this->service->find($id);

        return response()->json([
            'success' => $result->success,
            'data'    => $result->data,
            'message' => $result->message,
        ], $result->statusCode);
    }

    public function managerReview(Request $request, string $id)
    {
        $result = $this->service->managerReview($id, $request->only(['isApproved', 'comment', 'managerUserId']));

        return response()->json([
            'success' => $result->success,
            'message' => $result->success ? 'Review submitted successfully.' : $result->message,
            'data'    => $result->data,
        ], $result->statusCode);
    }

    public function adminReview(Request $request, string $id)
    {
        $result = $this->service->adminReview($id, $request->only(['isApproved', 'comment', 'adminUserId']));

        return response()->json([
            'success' => $result->success,
            'message' => $result->success ? 'Review submitted successfully.' : $result->message,
            'data'    => $result->data,
        ], $result->statusCode);
    }

    public function progress(Request $request, string $id)
    {
        $result = $this->service->progress($id, $request->only(['status', 'comment']));

        return response()->json([
            'success' => $result->success,
            'message' => $result->success ? 'Status updated successfully.' : $result->message,
            'data'    => $result->data,
        ], $result->statusCode);
    }

    public function productsDataTable(Request $request)
    {
        $params = $request->only(['draw', 'start', 'length', 'search', 'order', 'columns', 'categoryId']);
        $result = $this->service->productsDataTable($params);

        if ($result->success) {
            return response()->json($result->data);
        }

        return response()->json(['error' => $result->message], $result->statusCode);
    }

    public function categoriesOptions()
    {
        $result = $this->service->getCategories();

        return response()->json([
            'data' => $result->success ? ($result->data ?? []) : [],
        ]);
    }
}
