<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Crear la nueva tabla licencias
        Schema::create('licencias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conductor_id')->constrained('conductores')->onDelete('cascade');
            $table->string('no_licencia')->nullable();
            $table->string('clase');
            $table->date('vence');
            $table->boolean('activa')->default(true);
            $table->timestamps();
        });

        // 2. Migrar los datos existentes de la tabla conductores a licencias
        if (Schema::hasColumn('conductores', 'clase')) {
            $conductores = DB::table('conductores')
                ->whereNotNull('clase')
                ->whereNotNull('vence')
                ->get();

            foreach ($conductores as $conductor) {
                DB::table('licencias')->insert([
                    'conductor_id' => $conductor->id,
                    'no_licencia'  => $conductor->no_licencia,
                    'clase'        => $conductor->clase,
                    'vence'        => $conductor->vence,
                    'activa'       => $conductor->activo ?? true,
                    'created_at'   => now(),
                    'updated_at'   => now(),
                ]);
            }

            // 3. Eliminar las columnas obsoletas de la tabla conductores
            Schema::table('conductores', function (Blueprint $table) {
                $table->dropColumn(['no_licencia', 'clase', 'vence']);
            });
        }
    }

    public function down(): void
    {
        // Restaurar columnas en conductores
        Schema::table('conductores', function (Blueprint $table) {
            $table->string('no_licencia')->nullable();
            $table->string('clase')->nullable();
            $table->date('vence')->nullable();
        });

        // Copiar datos de vuelta a conductores
        $licencias = DB::table('licencias')->get();
        foreach ($licencias as $licencia) {
            DB::table('conductores')
                ->where('id', $licencia->conductor_id)
                ->update([
                    'no_licencia' => $licencia->no_licencia,
                    'clase'       => $licencia->clase,
                    'vence'       => $licencia->vence,
                ]);
        }

        // Eliminar tabla licencias
        Schema::dropIfExists('licencias');
    }
};