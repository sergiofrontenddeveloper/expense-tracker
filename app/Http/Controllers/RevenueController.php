<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRevenueRequest;
use App\Models\Revenue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RevenueController extends Controller
{
    public function index(Request $request)
    {
        $query = Revenue::where('user_id', Auth::id());

        if ($search = $request->input('search')) {
            $query->where('description', 'like', "%{$search}%");
        }

        if ($date = $request->input('date')) {
            $query->whereDate('revenue_date', $date);
        }

        $revenues = $query->latest('revenue_date')->paginate(10)->withQueryString();

        return view('revenue.index', compact('revenues'));
    }

    public function store(StoreRevenueRequest $request)
    {
        Revenue::create([
            'user_id' => Auth::id(),
            'description' => $request->description,
            'amount' => $request->amount,
            'revenue_date' => $request->date,
        ]);

        return redirect()->route('revenue')->with('success', 'Ingreso añadido correctamente.');
    }

    public function update(StoreRevenueRequest $request, Revenue $revenue)
    {
        abort_unless($revenue->user_id === Auth::id(), 403);

        $revenue->update([
            'description' => $request->description,
            'amount' => $request->amount,
            'revenue_date' => $request->date,
        ]);

        return redirect()->route('revenue')->with('success', 'Ingreso actualizado correctamente.');
    }

    public function destroy(Revenue $revenue)
    {
        abort_unless($revenue->user_id === Auth::id(), 403);

        $revenue->delete();

        return redirect()->route('revenue')->with('success', 'Ingreso eliminado correctamente.');
    }
}
