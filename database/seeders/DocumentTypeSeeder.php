<?php

namespace Database\Seeders;

use App\Models\DocumentType;
use Illuminate\Database\Seeder;

class DocumentTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['name' => 'Cédula de Ciudadanía', 'abbreviation' => 'CC'],
            ['name' => 'Cédula de Extranjería', 'abbreviation' => 'CE'],
            ['name' => 'Tarjeta de Identidad', 'abbreviation' => 'TI'],
            ['name' => 'Registro Civil', 'abbreviation' => 'RC'],
            ['name' => 'Pasaporte', 'abbreviation' => 'PA'],
            ['name' => 'NIT', 'abbreviation' => 'NIT'],
            ['name' => 'Permiso Especial de Permanencia', 'abbreviation' => 'PEP']
        ];

        foreach ($types as $type) {
            DocumentType::create($type);
        }
    }
}