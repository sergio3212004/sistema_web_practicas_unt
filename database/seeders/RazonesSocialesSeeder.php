<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RazonesSocialesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('razones_sociales')->insert([
            [
                'acronimo' => 'S.A.C.S.'
            ],
            [
                'acronimo' => 'S.A.'
            ],
            [
                'acronimo' => 'S.A.C.'
            ],
            [
                'acronimo' => 'S.R.L.'
            ],
            [
                'acronimo' => 'E.I.R.L.'
            ],
            [
                'acronimo' => 'S.A.A.'
            ],
        ]);
    }
}
