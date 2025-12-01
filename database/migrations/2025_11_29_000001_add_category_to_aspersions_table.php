<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('aspersions', function (Blueprint $table) {
            $table->string('category')->nullable()->after('mix_code_id');
        });
    }

    public function down(): void
    {
        Schema::table('aspersions', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }
};
