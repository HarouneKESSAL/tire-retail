<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->integer('width')->after('size')->nullable();
            $table->integer('aspect_ratio')->after('width')->nullable();
            $table->integer('diameter')->after('aspect_ratio')->nullable();
            $table->string('year')->after('diameter')->nullable();
            $table->string('car_brand')->after('year')->nullable();
            $table->string('model')->after('car_brand')->nullable();
            $table->string('option')->after('model')->nullable();
            $table->enum('season', ['summer', 'all-season', 'winter'])->after('option')->nullable();
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['width', 'aspect_ratio', 'diameter', 'year', 'car_brand', 'model', 'option', 'season']);
        });
    }
};
