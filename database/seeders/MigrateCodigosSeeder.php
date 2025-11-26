<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MigrateCodigosSeeder extends Seeder
{
    public function run()
    {
        // Obtener la primera mezcla existente
        $mezclaId = DB::table('mezclas')->first()->id ?? null;
        
        if (!$mezclaId) {
            $mezclaId = DB::table('mezclas')->insertGetId([
                'nombre_mezcla' => 'IMPULSE 800 EC',
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // Asignar todos los códigos existentes a esta mezcla
        DB::table('codigos')->whereNull('mezcla_id')->update(['mezcla_id' => $mezclaId]);
    }
}