<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['car_brand', 'model', 'year']);
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('car_brand')->nullable();
            $table->string('model')->nullable();
            $table->string('year')->nullable();
        });
    }

};
