<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('aspersions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('finca_id')->constrained('fincas');
            $table->foreignId('user_id')->constrained('users');
            $table->date('application_date');
            $table->integer('week_number');
            $table->decimal('hectares', 10, 2);
            $table->text('mix_description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aspersions');
    }
};