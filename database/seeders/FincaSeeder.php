<?php

namespace Database\Seeders;

use App\Models\Finca;
use Illuminate\Database\Seeder;

class FincaSeeder extends Seeder
{
    public function run(): void
    {
        $fincas = [
            ['name' => 'LA CATALINA', 'ibm' => 'CAT001', 'hectares' => 150.50],
            ['name' => 'ARCUA', 'ibm' => 'ARC001', 'hectares' => 200.75],
            ['name' => 'CASCADA-AGRIPINA', 'ibm' => 'CAS001', 'hectares' => 180.25],
            ['name' => 'KATIA', 'ibm' => 'KAT001', 'hectares' => 120.00],
            ['name' => 'ANTARES', 'ibm' => 'ANT001', 'hectares' => 300.00],
            ['name' => 'VILLA MARÍA', 'ibm' => 'VMA001', 'hectares' => 250.50],
            ['name' => 'ESTAMPA', 'ibm' => 'EST001', 'hectares' => 175.25],
            ['name' => 'RETORNO', 'ibm' => 'RET001', 'hectares' => 190.75],
            ['name' => 'GENESIS FLO ID 40571', 'ibm' => 'GEN001', 'hectares' => 220.00],
            ['name' => 'VILLA CLEMENCIA', 'ibm' => 'VCL001', 'hectares' => 165.50],
            ['name' => 'EL ROBLE FLO ID 40571', 'ibm' => 'ROB001', 'hectares' => 210.25],
            ['name' => 'RINCON', 'ibm' => 'RIN001', 'hectares' => 140.75],
            ['name' => 'MARANDUA', 'ibm' => 'MAR001', 'hectares' => 185.00],
            ['name' => 'CARUBA-NIÑAS', 'ibm' => 'CAR001', 'hectares' => 155.50],
            ['name' => 'GUATAPURI', 'ibm' => 'GUA001', 'hectares' => 195.25],
            ['name' => 'ZUMBADORA', 'ibm' => 'ZUM001', 'hectares' => 170.75],
            ['name' => 'ABRAZO', 'ibm' => 'ABR001', 'hectares' => 160.00],
            ['name' => 'MONTAÑITA', 'ibm' => 'MON001', 'hectares' => 205.50],
            ['name' => 'PLANTACION', 'ibm' => 'PLA001', 'hectares' => 225.25],
            ['name' => 'CATIVOS', 'ibm' => 'CAT002', 'hectares' => 145.75],
            ['name' => 'GUINEO', 'ibm' => 'GUI001', 'hectares' => 135.00],
            ['name' => 'JACARANDA', 'ibm' => 'JAC001', 'hectares' => 175.50],
            ['name' => 'MONTECRISTO 2', 'ibm' => 'MC2001', 'hectares' => 190.25],
            ['name' => 'CANTHO', 'ibm' => 'CAN001', 'hectares' => 165.75],
            ['name' => 'HORIZONTES', 'ibm' => 'HOR001', 'hectares' => 180.00]
        ];

        foreach ($fincas as $finca) {
            Finca::create($finca);
        }
    }
}