<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('users')->insert([
            [
                'email'=>'smonge@unitru.edu.pe',
                'password'=>Hash::make('pene123'),
                'rol_id'=>1,
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'email'=>'admin@unitru.edu.pe',
                'password'=>Hash::make('pene123'),
                'rol_id'=>4,
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'email'=>'profesor2@unitru.edu.pe',
                'password'=>Hash::make('pene123'),
                'rol_id'=>2,
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'email'=>'smonge67000123@gmail.com',
                'password'=>Hash::make('pene123'),
                'rol_id'=>3,
                'created_at'=>now(),
                'updated_at'=>now()
            ]
        ]);
    }
}
