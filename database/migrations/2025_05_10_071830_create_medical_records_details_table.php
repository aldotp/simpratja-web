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
        Schema::create('medical_records_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('medical_record_id');
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('docter_id');
            $table->unsignedBigInteger('visit_id');
            $table->unsignedBigInteger('medicine_id');
            $table->date('examination_date');
            $table->string('complaint', 255);
            $table->string('diagnosis', 255);
            $table->timestamps();
            $table->foreign('medical_record_id')->references('id')->on('medical_records');
            $table->foreign('docter_id')->references('id')->on('users');
            $table->foreign('visit_id')->references('id')->on('visits');
            $table->foreign('medicine_id')->references('id')->on('medicines');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_records_details');
    }
};
