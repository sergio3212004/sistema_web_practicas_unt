<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('roles')->insert([
            [
                'nombre' => 'alumno',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'nombre' => 'profesor',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'nombre' => 'empresa',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'nombre' => 'administrador',
                'created_at'=>now(),
                'updated_at'=>now()
            ]
        ]);
    }
}
