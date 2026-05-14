<?php

namespace App\Http\Controllers;

use App\Services\DivisionService;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    public function __construct(private DivisionService $divisionService) {}

    public function index()
    {
        return view('pages.division', [
            'title' => 'Divisions',
        ]);
    }

    public function datatableAjax(Request $request)
    {
        $params = $request->only(['draw', 'start', 'length', 'search', 'order', 'columns']);
        $result = $this->divisionService->datatable($params);

        if ($result->success) {
            return response()->json($result->data);
        }

        return response()->json(['error' => $result->message], $result->statusCode);
    }

    public function store(Request $request)
    {
        $result = $this->divisionService->create($request->all());

        return response()->json([
            'success' => $result->success,
            'message' => $result->success ? 'Division created successfully.' : $result->message,
            'data'    => $result->data,
        ], $result->statusCode);
    }

    public function update(Request $request, string $id)
    {
        $result = $this->divisionService->update($id, $request->all());

        return response()->json([
            'success' => $result->success,
            'message' => $result->success ? 'Division updated successfully.' : $result->message,
            'data'    => $result->data,
        ], $result->statusCode);
    }

    public function destroy(string $id)
    {
        $result = $this->divisionService->destroy($id);

        return response()->json([
            'success' => $result->success,
            'message' => $result->success ? 'Division deleted successfully.' : $result->message,
        ], $result->statusCode);
    }
}
