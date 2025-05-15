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
            $table->integer('id', true, true)->length(10);
            $table->integer('medical_record_id', false, true)->length(10);
            $table->integer('doctor_id', false, true)->length(10);
            $table->integer('visit_id', false, true)->length(10);
            $table->integer('medicine_id', false, true)->length(10);
            $table->date('examination_date');
            $table->string('complaint', 255);
            $table->string('diagnosis', 255);
            $table->timestamps();

            $table->foreign('medical_record_id')->references('id')->on('medical_records');
            $table->foreign('doctor_id')->references('id')->on('docters');
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
