<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AulaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('aulas')->insert([
            'numero' => '1',
            'semestre_id' => '1',
            'profesor_id' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
