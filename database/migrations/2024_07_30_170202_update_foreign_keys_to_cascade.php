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
        // Update product_reviews table
        Schema::table('product_reviews', function (Blueprint $table) {
            // Drop the existing foreign key constraints
            $table->dropForeign(['user_id']);
            $table->dropForeign(['product_id']);

            // Add the new foreign key constraints with cascading deletes
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });

        // Update post_comments table
        Schema::table('post_comments', function (Blueprint $table) {
            // Drop the existing foreign key constraints
            $table->dropForeign(['user_id']);
            $table->dropForeign(['post_id']);

            // Add the new foreign key constraints with cascading deletes
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Revert changes to product_reviews table
        Schema::table('product_reviews', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['product_id']);

            $table->foreign('user_id')->references('id')->on('users')->onDelete('SET NULL');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('SET NULL');
        });

        // Revert changes to post_comments table
        Schema::table('post_comments', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['post_id']);

            $table->foreign('user_id')->references('id')->on('users')->onDelete('SET NULL');
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('SET NULL');
        });
    }
};
