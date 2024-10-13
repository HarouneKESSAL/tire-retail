<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {

            $table->boolean('runflat')->default(false);
            $table->boolean('pneu_renforce')->default(false);
            $table->boolean('extra_load')->default(false);
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {

            $table->dropColumn('runflat');
            $table->dropColumn('pneu_renforce');
            $table->dropColumn('extra_load');
        });
    }

};
