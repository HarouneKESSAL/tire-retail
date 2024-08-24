<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product_options', function (Blueprint $table) {
            // Drop the foreign key constraint first
            $table->dropForeign(['product_id']); // Replace 'product_options_product_id_foreign' with the actual constraint name if it's different

            // Now drop the product_id column
            $table->dropColumn('product_id');

            // Ensure name is unique
            $table->string('name')->unique()->change();

            // Make the type field optional
            $table->string('type')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('product_options', function (Blueprint $table) {
            // Add the product_id column back
            $table->unsignedBigInteger('product_id');

            // Restore the foreign key constraint
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

            // Drop unique constraint on name
            $table->dropUnique(['name']);
        });
    }
};
