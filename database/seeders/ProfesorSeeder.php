<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Nette\Schema\Schema;

class ProfesorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table("profesores")->insert([
            'codigo_profesor' => '1234567896',
            'user_id' => 3,
            'nombres' => 'Juan',
            'apellido_paterno' => 'Perez',
            'apellido_materno' => 'Perez',
            'telefono' => '963258147',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
