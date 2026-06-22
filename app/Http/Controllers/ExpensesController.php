<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExpenseRequest;
use App\Models\Category;
use App\Models\Expense;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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
        // 1. Creamos el gasto usando tu Request validada y tus columnas reales
        Expense::create([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'description' => $request->description,
            'amount' => $request->amount,
            'expense_date' => $request->date,
        ]);

        // 2. LÓGICA DE LA NOTIFICACIÓN
        // Sumamos los gastos usando tu columna real 'expense_date' y 'amount'
        $totalGastadoEsteMes = Expense::where('user_id', Auth::id())
            ->whereMonth('expense_date', Carbon::now()->month)
            ->whereYear('expense_date', Carbon::now()->year)
            ->sum('amount');

        $limitePresupuesto = 1000; // Límite estático provisional

        // Evitamos duplicar alertas idénticas en el mismo mes si el usuario sigue metiendo gastos
        if ($totalGastadoEsteMes >= $limitePresupuesto) {

            $yaAlertadoLimite = Notification::where('user_id', Auth::id())
                ->where('title', '🚨 Límite Superado')
                ->whereMonth('created_at', Carbon::now()->month)
                ->exists();

            if (!$yaAlertadoLimite) {
                Notification::create([
                    'user_id' => Auth::id(),
                    'title' => '🚨 Límite Superado',
                    'message' => 'Has superado tu límite de presupuesto mensual. Total gastado: ' . $totalGastadoEsteMes . '€',
                    'is_read' => false,
                ]);
            }

        } elseif ($totalGastadoEsteMes >= ($limitePresupuesto * 0.8)) {

            $yaAlertadoAdvertencia = Notification::where('user_id', Auth::id())
                ->where('title', '⚠️ Alerta de Presupuesto')
                ->whereMonth('created_at', Carbon::now()->month)
                ->exists();

            if (!$yaAlertadoAdvertencia) {
                Notification::create([
                    'user_id' => Auth::id(),
                    'title' => '⚠️ Alerta de Presupuesto',
                    'message' => 'Has alcanzado el 80% de tu presupuesto mensual. Llevas gastado: ' . $totalGastadoEsteMes . '€',
                    'is_read' => false,
                ]);
            }
        }

        // Redirección original corregida a tu ruta 'expenses'
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
