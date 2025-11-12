<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Control de Sigatoka', 'description' => 'Productos para control de sigatoka'],
            ['name' => 'Fertilizantes', 'description' => 'Productos fertilizantes'],
            ['name' => 'Desfoliadores', 'description' => 'Productos desfoliadores'],
            ['name' => 'Control de Plagas', 'description' => 'Productos para control de plagas']
        ];

        foreach ($categories as $category) {
            ProductCategory::create($category);
        }
    }
}