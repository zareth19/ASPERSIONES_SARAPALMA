<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::create(['name' => 'admin', 'description' => 'Administrador del sistema']);
        Role::create(['name' => 'administrativo', 'description' => 'Personal administrativo']);
        Role::create(['name' => 'finca', 'description' => 'Usuario de finca']);
    }
}