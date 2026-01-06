<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('empresas')->insert([
            'nombre'=>'Example Software',
            'user_id' => 4,
            'departamento' => 'La Libertad',
            'provincia' => 'Trujillo',
            'distrito' => 'Trujillo',
            'direccion' => 'calle 123',
            'razon_social_id' => 3,

            'telefono' => '968891526',
            'ruc' => '12345678912',
            'created_at'=>now(),
            'updated_at'=>now()
        ]);
    }
}
