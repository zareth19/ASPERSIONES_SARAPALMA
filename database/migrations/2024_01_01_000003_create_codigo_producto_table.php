<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('codigo_producto', function (Blueprint $table) {
            $table->id();
            $table->foreignId('codigo_id')->constrained('codigos')->onDelete('cascade');
            $table->foreignId('producto_id')->constrained('products')->onDelete('cascade');
            $table->decimal('cantidad', 8, 2);
            $table->timestamps();
            $table->unique(['codigo_id', 'producto_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('codigo_producto');
    }
};