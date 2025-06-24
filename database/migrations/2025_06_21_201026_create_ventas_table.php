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
      Schema::create('ventas', function (Blueprint $table) {
    $table->id();
    $table->string('codigo')->unique();
    $table->foreignId('user_id')->constrained();
    $table->decimal('subtotal', 10, 2);
    $table->decimal('impuesto', 10, 2);
    $table->decimal('descuento', 10, 2)->default(0);
    $table->decimal('total', 10, 2);
    $table->string('metodo_pago');
    $table->string('estado')->default('completada');
    $table->text('observaciones')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
