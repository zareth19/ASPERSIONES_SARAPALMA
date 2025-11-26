<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('codigos', function (Blueprint $table) {
            $table->foreignId('mezcla_id')->after('id')->constrained('mezclas')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('codigos', function (Blueprint $table) {
            $table->dropForeign(['mezcla_id']);
            $table->dropColumn('mezcla_id');
        });
    }
};