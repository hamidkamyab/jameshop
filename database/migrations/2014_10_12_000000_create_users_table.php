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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('lastname');
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('national_code',20)->unique();
            $table->string('phone',20)->unique();
            $table->string('telephone',20)->nullable();
            $table->string('birthday',20);
            $table->tinyInteger('gender')->unsigned();
            $table->string('shaba',32)->nullable();
            $table->integer('state')->default(0)->unsigned();
            $table->integer('city')->default(0)->unsigned();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
