<?php

use Illuminate\Support\Facades\Artisan;
use App\Models\Expense;
use App\Mail\MonthlyReportMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| REPORTE MENSUAL DE GASTOS
|--------------------------------------------------------------------------
*/

// 1. El Comando del Reporte
Artisan::command('app:send-monthly-report', function () {
    $inicioMesPasado = Carbon::now()->subMonth()->startOfMonth();
    $finMesPasado = Carbon::now()->subMonth()->endOfMonth();
    $nombreMes = $inicioMesPasado->translatedFormat('F Y');

    $totalGastado = Expense::whereBetween('expense_date', [$inicioMesPasado, $finMesPasado])
        ->sum('amount');

    $correoDestino = env('REPORT_EMAIL_DESTINATION', 'tu-email@ejemplo.com');

    Mail::to($correoDestino)->send(new MonthlyReportMail($totalGastado, $nombreMes));

    $this->info("Reporte de {$nombreMes} enviado a {$correoDestino}. Total: {$totalGastado}€.");
})->purpose('Calcula los gastos del mes pasado y envía el resumen');

// 2. Programación del Reporte (Día 1 de cada mes a las 08:00 AM)
Schedule::command('app:send-monthly-report')->monthlyOn(1, '08:00');


/*
|--------------------------------------------------------------------------
| COPIA DE SEGURIDAD AUTOMÁTICA DE LA BASE DE DATOS (SQLITE)
|--------------------------------------------------------------------------
*/

// 3. El Comando del Backup de SQLite
Artisan::command('db:backup', function () {
    // La ruta por defecto de tu base de datos SQLite en Laravel 11
    $rutaBaseDatos = database_path('database.sqlite');

    // Comprobamos si el archivo de la base de datos existe realmente
    if (!file_exists($rutaBaseDatos)) {
        $this->error("No se encontró el archivo database.sqlite en la carpeta database/");
        return;
    }

    // Le damos un nombre bonito al archivo que se va a adjuntar en el correo
    $nombreAdjunto = 'backup-' . now()->format('Y-m-d_H-i-s') . '.sqlite';
    $correoDestino = env('REPORT_EMAIL_DESTINATION', 'tu-email@ejemplo.com');

    try {
        // Al ser un archivo plano, simplemente lo adjuntamos directamente por correo
        Mail::raw("Hola Sergio, adjunto encontrarás el archivo completo de tu base de datos SQLite de Expense Tracker correspondiente a la copia de seguridad del día " . now()->format('d/m/Y') . ". Para restaurarla en el futuro, bastaría con reemplazar tu archivo database.sqlite por este.", function ($message) use ($rutaBaseDatos, $nombreAdjunto, $correoDestino) {
            $message->to($correoDestino)
                    ->subject("💾 SQLite Backup Semanal - Expense Tracker")
                    ->attach($rutaBaseDatos, [
                        'as' => $nombreAdjunto,
                        'mime' => 'application/x-sqlite3',
                    ]);
        });

        $this->info("¡Copia de seguridad realizada con éxito (SQLite) y enviada a {$correoDestino}!");

    } catch (\Exception $e) {
        $this->error("Error al enviar el backup por correo: " . $e->getMessage());
    }
})->purpose('Envía el archivo database.sqlite por correo como copia de seguridad');

// 4. Programación del Backup (Todos los domingos a las 23:59)
Schedule::command('db:backup')->weeklyOn(0, '23:59');
