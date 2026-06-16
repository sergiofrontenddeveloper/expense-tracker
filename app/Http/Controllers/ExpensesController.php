<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExpenseRequest;
use App\Models\Category;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpensesController extends Controller
{
    public function index(Request $request)
    {
        $query = Expense::with('category')
            ->where('user_id', Auth::id());

        if ($search = $request->input('search')) {
            $query->where('description', 'like', "%{$search}%");
        }

        if ($categoryId = $request->input('category_id')) {
            $query->where('category_id', $categoryId);
        }

        if ($date = $request->input('date')) {
            $query->whereDate('expense_date', $date);
        }

        $expenses = $query->latest('expense_date')->paginate(10)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('expenses.index', compact('expenses', 'categories'));
    }

    public function store(StoreExpenseRequest $request)
    {
        Expense::create([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'description' => $request->description,
            'amount' => $request->amount,
            'expense_date' => $request->date,
        ]);

        return redirect()->route('expenses')->with('success', 'Gasto añadido correctamente.');
    }

    public function update(StoreExpenseRequest $request, Expense $expense)
    {
        abort_unless($expense->user_id === Auth::id(), 403);

        $expense->update([
            'category_id' => $request->category_id,
            'description' => $request->description,
            'amount' => $request->amount,
            'expense_date' => $request->date,
        ]);

        return redirect()->route('expenses')->with('success', 'Gasto actualizado correctamente.');
    }

    public function destroy(Expense $expense)
    {
        abort_unless($expense->user_id === Auth::id(), 403);

        $expense->delete();

        return redirect()->route('expenses')->with('success', 'Gasto eliminado correctamente.');
    }
}
