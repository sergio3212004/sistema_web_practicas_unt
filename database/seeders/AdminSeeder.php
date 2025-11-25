<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('administradores')->insert([
            'user_id' => 2,
            'nombres' => 'Chibolo',
            'apellido_paterno' => 'Meepo',
            'apellido_materno' => 'Sideral',
            'telefono' => '968891526',
            'created_at'=>now(),
            'updated_at'=>now()
        ]);
    }
}
