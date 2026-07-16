<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('registro_combustibles', function (Blueprint $table) {
        $table->id();
        $table->string('sucursal');             // name="sucursal"
        $table->date('fecha');                  // name="fecha"
        $table->integer('no_vale');             // name="no_vale" <--- Ajustado
        $table->string('placa');                // name="placa"
        $table->string('usuario');              // name="usuario"
        $table->decimal('precio_galon', 8, 3);  // name="precio_galon"
        $table->decimal('galonaje', 8, 3);      // name="galonaje"
        $table->decimal('total_carga', 10, 2);  // Calculado automático
        $table->string('tipo_gas');             // name="tipo_gas"
        $table->integer('kilometraje');         // name="kilometraje"
        $table->string('area');                 // name="area"
        $table->timestamps();
    });
    }

    public function down(): void
    {
        Schema::dropIfExists('registro_combustibles');
    }
};
