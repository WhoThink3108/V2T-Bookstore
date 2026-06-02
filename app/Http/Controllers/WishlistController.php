<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlistIds = session()->get('wishlist', []);
        $books = Book::withAvg('reviews', 'rating')
            ->whereIn('id', $wishlistIds)
            ->get();

        return view('wishlist', compact('books'));
    }

    public function toggle(Request $request, $id)
    {
        $book = Book::findOrFail($id);
        $wishlist = session()->get('wishlist', []);

        if (in_array($id, $wishlist)) {
            // Xóa khỏi danh sách yêu thích
            $wishlist = array_values(array_diff($wishlist, [$id]));
            session()->put('wishlist', $wishlist);
            $message = '💔 Đã xóa "' . $book->title . '" khỏi danh sách yêu thích!';
            $status = 'removed';
        } else {
            // Thêm vào danh sách yêu thích
            $wishlist[] = (int)$id;
            session()->put('wishlist', $wishlist);
            $message = '❤️ Đã thêm "' . $book->title . '" vào danh sách yêu thích!';
            $status = 'added';
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'status' => $status,
                'message' => $message,
                'count' => count($wishlist)
            ]);
        }

        return redirect()->back()->with('success', $message);
    }
}
