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
        Schema::create('km_diarios', function (Blueprint $table) {
            $table->id();
            $table->string('sucursal');
            $table->string('placa');
            $table->integer('km_inicial');
            $table->integer('km_final');
            $table->integer('total_recorrido');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('km_diarios');
    }
};
