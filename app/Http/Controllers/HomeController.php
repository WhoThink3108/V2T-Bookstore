<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Lấy dữ liệu từ database
        $books = Book::all();
        $categories = Category::all();
        $books = Book::withAvg('reviews', 'rating')->latest()->take(4)->get();
        
        // Truyền sang view 'home'
        return view('home', compact('books'));
    }
}