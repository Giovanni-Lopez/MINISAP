<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehiculos', function (Blueprint $table) {
            $table->id();
            $table->string('placa')->unique(); // Dominio
            $table->integer('anio');
            $table->string('marca');
            $table->string('modelo');
            $table->string('capacidad');
            $table->string('tipo');
            $table->string('clase');
            $table->string('en_calidad'); // Propio, Rentado, etc.
            $table->string('color');
            $table->string('n_chasis')->unique();
            $table->string('n_motor')->unique();
            $table->string('n_vin')->unique();
            $table->boolean('activo')->default(true); // Para dar de alta/baja lógica
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehiculos');
    }
};