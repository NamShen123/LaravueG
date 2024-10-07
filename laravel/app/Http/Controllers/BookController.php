<?php

namespace App\Http\Controllers;

use App\Models\Books;
use App\Models\BookStatus;
use Illuminate\Http\Request;

class BookController extends Controller
{
    function index(Request $request)
    {
        $books = Books::with('status')
        ->whereHas('status', fn($query) => $query->where('name', BookStatus::ACTIVE))
        ->paginate(12);
        return response()->json($books);
    }

    function userBooks(Request $request) {
        $user = $request->user();

        $borringBooks = Books::borringByUser($user->id)->get();
        return response()->json([
            'borring_books' => $borringBooks
        ]);
    }
}
