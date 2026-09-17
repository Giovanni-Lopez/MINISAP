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
    Schema::create('incidencias', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->nullable()->after('id')->constrained('users')->onDelete('cascade');
        $table->string('sucursal');
        $table->string('placa')->nullable();
        $table->text('descripcion');
        $table->json('revisiones')->nullable();
        $table->enum('urgencia', ['Baja', 'Media', 'Alta', 'Crítica'])->default('Media');
        $table->string('imagen_evidencia')->nullable();
        $table->enum('estado', ['Pendiente', 'En Revisión', 'Resuelto'])->default('Pendiente');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incidencias');
    }
};
