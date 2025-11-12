<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fincas', function (Blueprint $table) {
            $table->string('cc', 10)->nullable();
            $table->string('extension', 10)->nullable();
            $table->string('direct_phone', 20)->nullable();
            $table->string('administrator_name')->nullable();
            $table->string('administrator_phone', 20)->nullable();
            $table->string('office_worker_name')->nullable();
            $table->string('office_worker_phone', 20)->nullable();
            $table->string('coordinator_name')->nullable();
            $table->string('coordinator_phone', 20)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('fincas', function (Blueprint $table) {
            $table->dropColumn([
                'cc', 'extension', 'direct_phone', 'administrator_name', 
                'administrator_phone', 'office_worker_name', 'office_worker_phone',
                'coordinator_name', 'coordinator_phone'
            ]);
        });
    }
};