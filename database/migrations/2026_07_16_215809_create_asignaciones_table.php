<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asignaciones', function (Blueprint $table) {
            $table->id();
            
            // Relación con el vehículo
            $table->foreignId('vehiculo_id')->constrained('vehiculos')->onDelete('cascade');
            
            // Relación con el usuario (nullable por si se asigna a la sucursal pero no a un chofer específico aún)
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            
            // Sucursal o Área a la que pertenece actualmente la asignación
            $table->string('sucursal'); 
            
            // Control de asignaciones activas (historial)
            $table->boolean('activo')->default(true); // true = asignación vigente, false = asignación pasada
            $table->date('fecha_asignacion');
            $table->date('fecha_devolucion')->nullable(); // Para cuando se libere el vehículo
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asignaciones');
    }
};