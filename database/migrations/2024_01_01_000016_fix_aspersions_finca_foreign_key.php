<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('aspersions', function (Blueprint $table) {
            $table->dropForeign('aspersions_ibfk_1');
            $table->foreign('finca_id')->references('id')->on('fincas_temp');
        });
    }

    public function down(): void
    {
        Schema::table('aspersions', function (Blueprint $table) {
            $table->dropForeign(['finca_id']);
            $table->foreign('finca_id')->references('id')->on('fincas');
        });
    }
};