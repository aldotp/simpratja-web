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
        Schema::create('docters', function (Blueprint $table) {
            $table->integer('id', true, true)->length(10);
            $table->string('name', 50);
            $table->string('nik', 20);
            $table->integer('gender')->length(1);
            $table->string('phone_number', 20);
            $table->integer('quota')->length(10);
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('docters');
    }
};