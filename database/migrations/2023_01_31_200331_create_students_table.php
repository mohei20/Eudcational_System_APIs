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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('f_name');
            $table->string('m_name');
            $table->string('l_name');
            $table->string('phone_number');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('guardian_number');
            $table->string('year');
            $table->string('month');
            $table->integer('day');
            $table->integer('acedemic_year');
            $table->enum('division', [1, 2, 3, 4, 5])->comment('1 => general
            , 2=> scientific, 3=>Literary , 4=> Scientific mathematics , 5=> Scientific science');
            $table->string('national_id_card');
            $table->foreignId('governorate_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
};
