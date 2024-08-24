<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('product_options', function (Blueprint $table) {
            $table->string('value')->after('type'); // Add the value column back
        });

        Schema::table('product_option_product', function (Blueprint $table) {
            $table->dropColumn('value'); // Remove the value column
        });
    }

    public function down()
    {
        Schema::table('product_options', function (Blueprint $table) {
            $table->dropColumn('value')->nullable()->change();
        });

        Schema::table('product_option_product', function (Blueprint $table) {
            $table->string('value')->nullable()->after('product_option_id');
        });
    }

};
