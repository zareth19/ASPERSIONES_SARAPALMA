<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Deshabilitar verificación de claves foráneas temporalmente
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Crear nueva tabla con orden correcto
        Schema::create('fincas_new', function (Blueprint $table) {
            $table->id();
            $table->string('cc', 10)->nullable();
            $table->decimal('hectares', 10, 2);
            $table->string('ibm', 20)->unique();
            $table->string('name');
            $table->string('extension', 10)->nullable();
            $table->string('direct_phone', 20)->nullable();
            $table->string('administrator_name')->nullable();
            $table->string('administrator_phone', 20)->nullable();
            $table->string('office_worker_name')->nullable();
            $table->string('office_worker_phone', 20)->nullable();
            $table->string('coordinator_name')->nullable();
            $table->string('coordinator_phone', 20)->nullable();
            $table->string('location')->nullable();
            $table->boolean('active')->default(true);
            $table->string('password')->nullable();
            $table->timestamps();
        });

        // Copiar datos
        DB::statement('INSERT INTO fincas_new SELECT * FROM fincas');

        // Eliminar tabla original y renombrar
        Schema::drop('fincas');
        Schema::rename('fincas_new', 'fincas');
        
        // Rehabilitar verificación de claves foráneas
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    public function down(): void
    {
        // No revertir
    }
};