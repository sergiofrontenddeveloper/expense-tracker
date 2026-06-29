<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\Revenue; // Importamos tu modelo de ingresos
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExpenseExportController extends Controller
{
    public function exportMonth($year, $month): StreamedResponse
    {
        $fecha = Carbon::createFromDate($year, $month, 1);
        $nombreMes = $fecha->translatedFormat('F-Y');
        $nombreArchivo = "balance-separado-{$nombreMes}.csv";

        // 1. Obtener los Gastos del mes ordenados por fecha
        $gastos = Expense::whereYear('expense_date', $year)
            ->whereMonth('expense_date', $month)
            ->orderBy('expense_date', 'asc')
            ->get();

        // 2. Obtener los Ingresos del mes ordenados por fecha
        $ingresos = Revenue::whereYear('revenue_date', $year)
            ->whereMonth('revenue_date', $month)
            ->orderBy('revenue_date', 'asc')
            ->get();

        // 3. Generar la descarga en Streaming dividida por bloques
        return response()->streamDownload(function () use ($gastos, $ingresos) {
            $file = fopen('php://output', 'w');

            // Marca BOM para que Excel detecte bien las tildes y el símbolo €
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            /*
            |--------------------------------------------------------------------------
            | BLOQUE 1: GASTOS
            |--------------------------------------------------------------------------
            */
            fputcsv($file, ['--- SECCIÓN DE GASTOS ---']);
            fputcsv($file, ['Fecha', 'Descripción', 'Categoría', 'Cantidad (€)']);

            foreach ($gastos as $gasto) {
                // Limpieza de la categoría JSON que ya teníamos configurada
                $nombreCategoria = 'Sin categoría';
                if (!empty($gasto->category)) {
                    if (is_array($gasto->category) && isset($gasto->category['name'])) {
                        $nombreCategoria = $gasto->category['name'];
                    } elseif (is_object($gasto->category) && isset($gasto->category->name)) {
                        $nombreCategoria = $gasto->category->name;
                    }
                }

                fputcsv($file, [
                    Carbon::parse($gasto->expense_date)->format('d/m/Y'),
                    $gasto->description,
                    $nombreCategoria,
                    number_format($gasto->amount, 2, ',', '.')
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | SEPARACIÓN VISUAL BETWEEN SECTIONS
            |--------------------------------------------------------------------------
            */
            fputcsv($file, []); // Línea vacía
            fputcsv($file, []); // Línea vacía

            /*
            |--------------------------------------------------------------------------
            | BLOQUE 2: INGRESOS
            |--------------------------------------------------------------------------
            */
            fputcsv($file, ['--- SECCIÓN DE INGRESOS ---']);
            fputcsv($file, ['Fecha', 'Descripción', 'Categoría', 'Cantidad (€)']);

            foreach ($ingresos as $ingreso) {
                fputcsv($file, [
                    Carbon::parse($ingreso->revenue_date)->format('d/m/Y'),
                    $ingreso->description,
                    $ingreso->category ?? 'Ingreso General',
                    number_format($ingreso->amount, 2, ',', '.')
                ]);
            }

            fclose($file);
        }, $nombreArchivo, [
            'Content-Type' => 'text/csv',
        ]);
    }
}
