<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('media_files_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('media_file_id');
            $table->unsignedBigInteger('product_id');
            $table->tinyInteger('first')->default('0');
            $table->timestamps();

            $table->foreign('media_file_id')->references('id')->on('media_files')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media_files_products');
    }
};
