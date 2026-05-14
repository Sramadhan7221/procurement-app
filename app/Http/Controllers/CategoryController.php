<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(private CategoryService $categoryService) {}

    public function index()
    {
        return view('pages.category', [
            'title' => 'Categories',
        ]);
    }

    public function datatableAjax(Request $request)
    {
        $params = $request->only(['draw', 'start', 'length', 'search', 'order', 'columns']);
        $result = $this->categoryService->datatable($params);

        if ($result->success) {
            return response()->json($result->data);
        }

        return response()->json(['error' => $result->message], $result->statusCode);
    }

    public function store(Request $request)
    {
        $result = $this->categoryService->create($request->all());

        return response()->json([
            'success' => $result->success,
            'message' => $result->success ? 'Category created successfully.' : $result->message,
            'data'    => $result->data,
        ], $result->statusCode);
    }

    public function update(Request $request, string $id)
    {
        $result = $this->categoryService->update($id, $request->all());

        return response()->json([
            'success' => $result->success,
            'message' => $result->success ? 'Category updated successfully.' : $result->message,
            'data'    => $result->data,
        ], $result->statusCode);
    }

    public function destroy(string $id)
    {
        $result = $this->categoryService->destroy($id);

        return response()->json([
            'success' => $result->success,
            'message' => $result->success ? 'Category deleted successfully.' : $result->message,
        ], $result->statusCode);
    }
}
