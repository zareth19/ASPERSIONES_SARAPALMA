<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mezcal', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_mezcla');
            $table->decimal('cantidad_aplicacion', 8, 2);
            $table->foreignId('producto_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('codigo_id')->constrained('codigos')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mezcal');
    }
};