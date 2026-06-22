<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Añade una columna decimal de 10 dígitos en total y 2 decimales
            // El 'after' es opcional, sirve para que en la BD se coloque visualmente después de la contraseña
            $table->decimal('monthly_limit', 10, 2)->default(1000.00)->after('password');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Si hacemos un rollback, eliminamos la columna de forma limpia
            $table->dropColumn('monthly_limit');
        });
    }
};
