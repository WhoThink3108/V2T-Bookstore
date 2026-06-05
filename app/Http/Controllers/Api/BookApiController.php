<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class BookApiController extends Controller
{
    // 1. Lấy danh sách sách (GET /api/books)
    public function index(Request $request)
    {
        $keyword = $request->input('search');
        $categoryId = $request->input('category_id');

        $books = Book::with('category')
            ->when($keyword, function ($query, $keyword) {
                return $query->where('title', 'like', "%{$keyword}%")
                             ->orWhere('author', 'like', "%{$keyword}%");
            })
            ->when($categoryId, function ($query, $categoryId) {
                return $query->where('category_id', $categoryId);
            })
            ->latest()
            ->paginate(15);

        $responseData = [
            'success' => true,
            'message' => 'Lấy danh sách sách thành công',
            'data' => $books
        ];

        if ($request->acceptsHtml() && !$request->expectsJson()) {
            return view('api.explorer', [
                'title' => 'Danh sách Sách API',
                'endpoint' => '/api/books',
                'type' => 'books',
                'data' => $books->items(),
                'raw_data' => $responseData
            ]);
        }

        return response()->json($responseData, Response::HTTP_OK);
    }

    // 2. Tạo sách mới (POST /api/books)
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'image_url' => 'nullable|string',
        ]);

        // Tự động tạo slug từ title
        $validatedData['slug'] = Str::slug($validatedData['title']) . '-' . rand(1000, 9999);

        $book = Book::create($validatedData);
        $book->load('category');

        return response()->json([
            'success' => true,
            'message' => 'Thêm sách thành công',
            'data' => $book
        ], Response::HTTP_CREATED);
    }

    // 3. Lấy chi tiết một cuốn sách (GET /api/books/{id})
    public function show(string $id)
    {
        $book = Book::with('category')->find($id);

        if (!$book) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy sách'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'message' => 'Lấy chi tiết sách thành công',
            'data' => $book
        ], Response::HTTP_OK);
    }

    // 4. Cập nhật thông tin sách (PUT/PATCH /api/books/{id})
    public function update(Request $request, string $id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy sách'
            ], Response::HTTP_NOT_FOUND);
        }

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'image_url' => 'nullable|string',
        ]);

        // Cập nhật slug nếu title thay đổi
        if ($book->title !== $validatedData['title']) {
            $validatedData['slug'] = Str::slug($validatedData['title']) . '-' . rand(1000, 9999);
        }

        $book->update($validatedData);
        $book->load('category');

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật sách thành công',
            'data' => $book
        ], Response::HTTP_OK);
    }

    // 5. Xóa sách (DELETE /api/books/{id})
    public function destroy(string $id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy sách'
            ], Response::HTTP_NOT_FOUND);
        }

        $book->delete();

        return response()->json([
            'success' => true,
            'message' => 'Xóa sách thành công'
        ], Response::HTTP_OK);
    }
}
