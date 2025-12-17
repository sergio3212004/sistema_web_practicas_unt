<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SemestreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('semestres')->insert([
           [
               'nombre' => '2025-I',
               'activo' => true,
               'created_at' => now(),
               'updated_at' => now()
           ]
        ]);
    }
}
