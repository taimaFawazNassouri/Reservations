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
        Schema::create('detail_passenger_confirms', function (Blueprint $table) {
            $table->id();
            // $table->string('referinceId');
            $table->string('title');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('nationality');
            $table->date('date_of_birth');
            $table->string('passport_number');
            $table->string('passport_issued_country');
            $table->date('passport_expiry_date');
            $table->string('city');
            $table->string('country_of_residence');
            $table->string('email');
            $table->string('country_code_phone');
            $table->string('phone');
            $table->string('country_code_travel')->nullable();
            $table->string('phone_travel')->nullable();
            $table->string('document_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_passenger_confirms');
    }
};
