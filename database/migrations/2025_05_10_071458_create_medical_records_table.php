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
        Schema::create('medical_records', function (Blueprint $table) {
            $table->integer('id', true, true)->length(10);
            $table->integer('patient_id', false, true)->length(10);
            $table->string('medical_record_number', 20);
            $table->timestamps();

            $table->foreign('patient_id')->references('id')->on('patients');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_record_details');
    }
};
