<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aspersion_codigo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aspersion_id')->constrained('aspersions')->onDelete('cascade');
            $table->foreignId('codigo_id')->constrained('codigos')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aspersion_codigo');
    }
};
