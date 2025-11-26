<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('aspersions', function (Blueprint $table) {
            $table->foreignId('mix_code_id')->nullable()->after('aspersed_lots')->constrained('codigos')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('aspersions', function (Blueprint $table) {
            $table->dropForeign(['mix_code_id']);
            $table->dropColumn('mix_code_id');
        });
    }
};