<?php

use Illuminate\Support\Facades\Artisan;
use App\Models\Expense;
use App\Mail\MonthlyReportMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schedule;

// 1. El Comando
Artisan::command('app:send-monthly-report', function () {
    // Calcular fechas y total
    // CAMBIA ESTO TEMPORALMENTE PARA LA PRUEBA:
$inicioMesPasado = Carbon::now()->startOfMonth(); // Inicio de este mes
$finMesPasado = Carbon::now()->endOfMonth();     // Fin de este mes
$nombreMes = $inicioMesPasado->translatedFormat('F Y'); // Saldrá "junio 2026"

    $totalGastado = Expense::whereBetween('expense_date', [$inicioMesPasado, $finMesPasado])
        ->sum('amount');

    // Destino (usando el .env, con fallback)
    $correoDestino = env('REPORT_EMAIL_DESTINATION', 'tu-email@ejemplo.com');

    // Enviar email
    Mail::to($correoDestino)->send(new MonthlyReportMail($totalGastado, $nombreMes));

    $this->info("Reporte de {$nombreMes} enviado a {$correoDestino}. Total: {$totalGastado}€.");
})->purpose('Calcula los gastos del mes pasado y envía el resumen');


// 2. La Programación (Schedule)
// Esto dice que el comando anterior se ejecute el día 1 de cada mes a las 08:00 AM
Schedule::command('app:send-monthly-report')->monthlyOn(1, '08:00');
