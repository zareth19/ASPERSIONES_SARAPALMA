<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('aspersions', function (Blueprint $table) {
            $table->string('application_type')->default('aplicacion_1'); // aplicacion_1, aplicacion_2
            $table->text('aspersed_lots')->nullable(); // lotes asperjados
            $table->foreignId('mix_code_id')->nullable()->constrained('mix_codes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('aspersions', function (Blueprint $table) {
            $table->dropForeign(['mix_code_id']);
            $table->dropColumn(['application_type', 'aspersed_lots', 'mix_code_id']);
        });
    }
};
