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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('position');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('link')->nullable();
            $table->string('color')->nullable();
            $table->tinyInteger('is_link');
            $table->unsignedBigInteger('parent_id')->default(0);
            $table->tinyInteger('best')->unsigned()->default(0);
            $table->string('best_title')->nullable();
            $table->string('best_link')->nullable();
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories')->nullOnDelete()->onUpdate('null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
