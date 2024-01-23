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
        Schema::create('amazing_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('amazing_id');
            $table->unsignedBigInteger('product_id');
            $table->timestamps();

            $table->foreign('amazing_id')->references('id')->on('amazings')->cascadeOnDelete();
            $table->foreign('product_id')->references('id')->on('products')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amazing_products');
    }
};
