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
        Schema::table('alertas', function (Blueprint $table) {
            // Primero eliminamos la restricción existente
            $table->dropForeign(['medicamento_id']);

            // Luego la volvemos a crear con onDelete('CASCADE')
            $table->foreign('medicamento_id')
                ->references('id')->on('medicamentos')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('alertas', function (Blueprint $table) {
            // Revertimos: quitamos la nueva restricción y agregamos una sin CASCADE
            $table->dropForeign(['medicamento_id']);

            $table->foreign('medicamento_id')
                ->references('id')->on('medicamentos');
                // Por defecto: onDelete('RESTRICT') o ninguna acción
        });
    }
};
