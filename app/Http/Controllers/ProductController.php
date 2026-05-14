<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(private ProductService $productService) {}

    public function index()
    {
        return view('pages.product', [
            'title' => 'Products',
        ]);
    }

    public function datatableAjax(Request $request)
    {
        $params = $request->only(['draw', 'start', 'length', 'search', 'order', 'columns']);
        $result = $this->productService->datatable($params);

        if ($result->success) {
            return response()->json($result->data);
        }

        return response()->json(['error' => $result->message], $result->statusCode);
    }

    public function options()
    {
        $categories = $this->productService->getCategories();
        $vendors    = $this->productService->getVendors();

        return response()->json([
            'categories' => $categories->success ? ($categories->data ?? []) : [],
            'vendors'    => $vendors->success ? ($vendors->data ?? []) : [],
        ]);
    }

    public function store(Request $request)
    {
        $data = [
            'SKU'        => $request->input('SKU'),
            'Name'       => $request->input('Name'),
            'CategoryId' => $request->input('CategoryId'),
            'BasePrice'  => $request->input('BasePrice'),
            'UoM'        => $request->input('UoM'),
            'Detail'     => $request->input('Detail'),
            'VendorId'   => $request->input('VendorId'),
        ];

        $files = [];
        if ($request->hasFile('ProductImage')) {
            $files['ProductImage'] = $request->file('ProductImage');
        }

        $result = $this->productService->create($data, $files);

        return response()->json([
            'success' => $result->success,
            'message' => $result->success ? 'Product created successfully.' : $result->message,
            'data'    => $result->data,
        ], $result->statusCode);
    }

    public function update(Request $request, string $id)
    {
        $data = [
            'SKU'        => $request->input('SKU'),
            'Name'       => $request->input('Name'),
            'CategoryId' => $request->input('CategoryId'),
            'BasePrice'  => $request->input('BasePrice'),
            'UoM'        => $request->input('UoM'),
            'Detail'     => $request->input('Detail'),
            'VendorId'   => $request->input('VendorId'),
        ];

        $files = [];
        if ($request->hasFile('ProductImage')) {
            $files['ProductImage'] = $request->file('ProductImage');
        } else {
            $data['ProductImage'] = null;
        }

        $result = $this->productService->update($id, $data, $files);

        return response()->json([
            'success' => $result->success,
            'message' => $result->success ? 'Product updated successfully.' : $result->message,
            'data'    => $result->data,
        ], $result->statusCode);
    }

    public function destroy(string $id)
    {
        $result = $this->productService->destroy($id);

        return response()->json([
            'success' => $result->success,
            'message' => $result->success ? 'Product deleted successfully.' : $result->message,
        ], $result->statusCode);
    }
}
