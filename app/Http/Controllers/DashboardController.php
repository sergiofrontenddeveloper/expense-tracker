<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $labels = ['Enero', 'Febrero', 'Marzo', 'Abril'];
        $data = [120, 90, 300, 250];

        return view('dashboard.index', [
            'labels' => $labels,
            'data' => $data
        ]);
    }
}
