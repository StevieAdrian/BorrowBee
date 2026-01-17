<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use App\Models\BorrowedBook;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total_books' => Book::count(),
            'total_users' => User::where('role_id', '!=', 1)->count(),
            'total_borrowed' => BorrowedBook::whereNull('returned_at')->count(),
            'pending_returns' => BorrowedBook::whereNull('returned_at')->where('due_date', '<', now())->count(),
        ];

        $borrowingTrend = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $count = BorrowedBook::whereDate('borrowed_at', $date)->count();
            $borrowingTrend[] = [
                'date' => $date->format('M d'),
                'count' => $count
            ];
        }

        $topCategories = Category::withCount('books')->orderByDesc('books_count')->limit(5)->get();

        $booksAvailability = [
            'available' => Book::where('is_available', true)->count(),
            'borrowed' => BorrowedBook::whereNull('returned_at')->count(),
        ];

        $recentBorrows = BorrowedBook::with(['user', 'book'])->orderByDesc('borrowed_at')->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'borrowingTrend', 'topCategories', 'booksAvailability', 'recentBorrows'));
    }
}

