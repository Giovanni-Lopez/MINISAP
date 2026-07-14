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
    Schema::create('vehiculos', function (Blueprint $table) {
        $table->id();
        $table->string('sucursal'); // Ej. 'Suc. Ilopango', 'Distribucion', etc.
        $table->string('placa')->unique(); // La placa del camión (ej. M-966030)
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('vehiculos');
}
};
