<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Expense;
use Tests\TestCase;

class ExpenseTrackerTest extends TestCase
{
    // Este trait vacía y prepara la base de datos en memoria antes de cada test
    use RefreshDatabase;

    /** @test */
    public function un_usuario_no_autenticado_no_puede_ver_los_archivos()
    {
        // Al intentar entrar a la sección de archivos sin loguearse...
        $response = $this->get('/files');

        // El sistema debe redirigirle al login (protección del middleware 'auth')
        $response->assertRedirect('/login');
    }

    /** @test */
    public function un_usuario_autenticado_puede_crear_un_gasto()
    {
        // 1. Creamos un usuario ficticio y lo autenticamos
        $user = User::factory()->create();
        $this->actingAs($user);

        // 2. Simulamos el envío del formulario para registrar un gasto
        $response = $this->post('/expenses', [
            'description' => 'Compra de servidor VPS',
            'amount' => 45.50,
            'expense_date' => '2026-06-29',
            'category' => ['name' => 'Tecnología'] // Estructura JSON mapeada
        ]);

        // 3. Comprobamos que redirige bien tras guardar (comportamiento habitual de un controlador)
        $response->assertRedirect();

        // 4. Aseguramos que el registro existe de verdad en la base de datos de pruebas
        $this->assertDatabaseHas('expenses', [
            'description' => 'Compra de servidor VPS',
            'amount' => 45.50
        ]);
    }

    /** @test */
    public function la_exportacion_del_reporte_mensual_en_streaming_funciona_correctamente()
    {
        // 1. Autenticamos a un usuario
        $user = User::factory()->create();
        $this->actingAs($user);

        // 2. Creamos un gasto ficticio asociado en ese mes para que tenga datos que procesar
        Expense::factory()->create([
            'expense_date' => '2026-06-15',
            'amount' => 100.00
        ]);

        // 3. Llamamos a la ruta de tu ExpenseExportController (junio de 2026)
        $response = $this->get('/expenses/export/2026/6');

        // 4. Verificaciones de integridad del Streaming y formato CSV
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
        $this->assertStringContainsString('--- SECCIÓN DE GASTOS ---', $response->streamedContent());
    }
}
