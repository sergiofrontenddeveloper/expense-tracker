<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Revenue;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $totalExpenses = Expense::where('user_id', $user->id)->sum('amount');
        $totalRevenue = Revenue::where('user_id', $user->id)->sum('amount');
        $balance = $totalRevenue - $totalExpenses;
        $savings = max($balance, 0);

        $months = collect(range(5, 0))->map(fn ($i) => Carbon::now()->subMonths($i));
        $labels = $months->map(fn ($m) => ucfirst($m->translatedFormat('M')))->values();
        $expenseData = $months->map(fn ($m) => Expense::where('user_id', $user->id)
            ->whereYear('expense_date', $m->year)
            ->whereMonth('expense_date', $m->month)
            ->sum('amount'))->values();
        $revenueData = $months->map(fn ($m) => Revenue::where('user_id', $user->id)
            ->whereYear('revenue_date', $m->year)
            ->whereMonth('revenue_date', $m->month)
            ->sum('amount'))->values();

        $recentExpenses = Expense::with('category')
            ->where('user_id', $user->id)
            ->latest('expense_date')
            ->limit(10)
            ->get()
            ->map(fn ($e) => [
                'description' => $e->description,
                'category' => $e->category->name,
                'date' => $e->expense_date,
                'amount' => $e->amount,
                'type' => 'expense',
            ]);

        $recentRevenues = Revenue::where('user_id', $user->id)
            ->latest('revenue_date')
            ->limit(10)
            ->get()
            ->map(fn ($r) => [
                'description' => $r->description,
                'category' => 'Ingreso',
                'date' => $r->revenue_date,
                'amount' => $r->amount,
                'type' => 'revenue',
            ]);

        $recentTransactions = $recentExpenses
            ->concat($recentRevenues)
            ->sortByDesc('date')
            ->take(5)
            ->values();

        $unreadNotifications = $user->notifications()->where('is_read', false)->count();

        return view('dashboard.index', [
            'user' => $user,
            'totalExpenses' => $totalExpenses,
            'totalRevenue' => $totalRevenue,
            'balance' => $balance,
            'savings' => $savings,
            'labels' => $labels,
            'expenseData' => $expenseData,
            'revenueData' => $revenueData,
            'recentTransactions' => $recentTransactions,
            'unreadNotifications' => $unreadNotifications,
        ]);
    }
}
