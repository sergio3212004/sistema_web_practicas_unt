<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoActividadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('tipos_actividad')->insert([
            [
                'nombre' => 'Reporte',
                'modo_entrega' => 'drive',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Informe de Unidad',
                'modo_entrega' => 'drive',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Informe Final',
                'modo_entrega' => 'pdf',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
