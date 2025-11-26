<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MigrateMezcalDataSeeder extends Seeder
{
    public function run()
    {
        $mezcalData = DB::table('mezcal')->get();
        
        foreach ($mezcalData as $row) {
            DB::table('codigo_producto')->insert([
                'codigo_id' => $row->codigo_id,
                'producto_id' => $row->producto_id,
                'cantidad' => $row->cantidad_aplicacion,
                'created_at' => $row->created_at,
                'updated_at' => $row->updated_at
            ]);
        }
    }
}