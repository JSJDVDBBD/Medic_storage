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
        Schema::create('corte_cajas', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained();
    $table->date('fecha');
    $table->decimal('efectivo_inicial', 10, 2);
    $table->decimal('efectivo_final', 10, 2);
    $table->decimal('ventas_efectivo', 10, 2)->default(0);
    $table->decimal('ventas_tarjeta', 10, 2)->default(0);
    $table->decimal('ventas_transferencia', 10, 2)->default(0);
    $table->decimal('total_ventas', 10, 2);
    $table->decimal('total_esperado', 10, 2);
    $table->decimal('diferencia', 10, 2);
    $table->text('observaciones')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('corte_caja');
    }
};
