<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Vehiculo;

class MigrarFlotaConfig extends Command
{
    protected $signature = 'flota:migrar-config';
    protected $description = 'Migra las placas desde el archivo de configuración a la base de datos';

    public function handle()
    {
        // 1. Jalamos las sucursales con placas de tu archivo config actual
        // Reemplaza 'flota.sucursales' por el nombre exacto de tu archivo si es diferente
        $configFlota = config('flota.sucursales', []); 

        if (empty($configFlota)) {
            // Si tu config se llama de otra forma, un respaldo común para no fallar:
            $configFlota = config('sucursalesConPlacas', []);
        }

        if (empty($configFlota)) {
            $this->error('No se encontró información en los archivos de configuración.');
            return;
        }

        $this->info('Iniciando migración de placas...');
        $insertados = 0;

        foreach ($configFlota as $sucursal => $placas) {
            foreach ($placas as $placa) {
                // Evitamos duplicados antes de insertar
                $existe = Vehiculo::where('placa', $placa)->exists();
                
                if (!$existe) {
                    Vehiculo::create([
                        'sucursal' => $sucursal,
                        'placa' => strtoupper($placa)
                    ]);
                    $insertados++;
                }
            }
        }

        $this->info("¡Listo! Se migraron {$insertados} vehículos a la base de datos de Railway.");
    }
}