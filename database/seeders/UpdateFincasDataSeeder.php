<?php

namespace Database\Seeders;

use App\Models\Finca;
use Illuminate\Database\Seeder;

class UpdateFincasDataSeeder extends Seeder
{
    public function run(): void
    {
        $fincasData = [
            ['ibm' => 'CAT001', 'cc' => '027', 'hectares' => 182.46, 'extension' => '9658', 'direct_phone' => '604 842 81 27', 'administrator_name' => 'Victor Alfonso Fuentes', 'administrator_phone' => '320 515 41 14', 'office_worker_name' => 'Tatiana Petro Zabala', 'office_worker_phone' => '315 925 19 96', 'coordinator_name' => 'Juan Guillermo Usuga', 'coordinator_phone' => '316 227 77 34'],
            ['ibm' => 'ARC001', 'cc' => '024', 'hectares' => 127.88, 'extension' => '9657', 'direct_phone' => '604 842 81 26', 'administrator_name' => 'Jhon Jeiler Ibarguen', 'administrator_phone' => '311 824 15 18', 'office_worker_name' => 'Gloria Elcy Gomez', 'office_worker_phone' => '316 360 64 33', 'coordinator_name' => 'Alfredo Viloria Negrete', 'coordinator_phone' => '316 625 96 21'],
            ['ibm' => 'CAS001', 'cc' => '012', 'hectares' => 148.10, 'extension' => '9659', 'direct_phone' => '604 842 81 28', 'administrator_name' => 'Francisco Velez', 'administrator_phone' => '321 464 97 92', 'office_worker_name' => 'Yudis Oviedo', 'office_worker_phone' => '315 256 01 74', 'coordinator_name' => 'Edilberto Cogollo Tordecillla', 'coordinator_phone' => '318 389 32 04'],
            ['ibm' => 'KAT001', 'cc' => '018', 'hectares' => 97.53, 'extension' => '9653', 'direct_phone' => '604 842 83 71', 'administrator_name' => 'Alberto Willian Marquez', 'administrator_phone' => '313 398 70 05', 'office_worker_name' => 'Lorena Serrano', 'office_worker_phone' => '315 401 08 53', 'coordinator_name' => 'Bladimir Bermudez', 'coordinator_phone' => '315 616 71 45'],
            ['ibm' => 'ANT001', 'cc' => '033', 'hectares' => 144.30, 'extension' => '9652', 'direct_phone' => '604 842 81 21', 'administrator_name' => 'Jairo Montenegro', 'administrator_phone' => '316 243 34 56', 'office_worker_name' => 'Armando Mostacilla', 'office_worker_phone' => '316 242 71 25', 'coordinator_name' => 'Nelson Fernando Rengifo', 'coordinator_phone' => '315 430 64 37']
        ];

        foreach ($fincasData as $data) {
            Finca::where('ibm', $data['ibm'])->update($data);
        }
    }
}