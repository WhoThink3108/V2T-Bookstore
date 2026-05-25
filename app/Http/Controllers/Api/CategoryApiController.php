<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryApiController extends Controller
{
    // 1. Lấy danh sách thể loại (GET /api/categories)
    public function index(Request $request)
    {
        $categories = Category::all();
        
        $responseData = [
            'success' => true,
            'message' => 'Lấy danh sách thể loại thành công',
            'data' => $categories
        ];

        if ($request->acceptsHtml() && !$request->expectsJson()) {
            return view('api.explorer', [
                'title' => 'Danh sách Thể Loại API',
                'endpoint' => '/api/categories',
                'type' => 'categories',
                'data' => $categories->toArray(),
                'raw_data' => $responseData
            ]);
        }

        return response()->json($responseData, Response::HTTP_OK);
    }

    // 2. Tạo thể loại mới (POST /api/categories)
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|unique:categories,name|max:255',
            'description' => 'nullable|string'
        ]);

        $category = Category::create($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Tạo thể loại thành công',
            'data' => $category
        ], Response::HTTP_CREATED);
    }

    // 3. Lấy chi tiết thể loại (GET /api/categories/{id})
    public function show(string $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy thể loại'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'message' => 'Lấy chi tiết thể loại thành công',
            'data' => $category
        ], Response::HTTP_OK);
    }

    // 4. Cập nhật thể loại (PUT/PATCH /api/categories/{id})
    public function update(Request $request, string $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy thể loại'
            ], Response::HTTP_NOT_FOUND);
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $id,
            'description' => 'nullable|string'
        ]);

        $category->update($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật thể loại thành công',
            'data' => $category
        ], Response::HTTP_OK);
    }

    // 5. Xóa thể loại (DELETE /api/categories/{id})
    public function destroy(string $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy thể loại'
            ], Response::HTTP_NOT_FOUND);
        }

        // Kiểm tra xem thể loại này có đang chứa sách không
        if ($category->books()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể xóa thể loại này vì vẫn đang chứa sách'
            ], Response::HTTP_BAD_REQUEST);
        }

        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Xóa thể loại thành công'
        ], Response::HTTP_OK);
    }
}
