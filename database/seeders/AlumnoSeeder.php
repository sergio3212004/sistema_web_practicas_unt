<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlumnoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('alumnos')->insert([
            'user_id' => 1,
            'codigo_matricula' => '1052701222',
            'nombres' => 'Sergio David Percy',
            'apellido_paterno' => 'Monge',
            'apellido_materno' => 'Muñoz',
            'telefono' => '968891526',
            'cv' => 'https://drive.google.com/file/d/1dhq67AC51Flag_DlsgxS7YKmDedaDDV4/view?usp=drive_link',
            'aula_id' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
