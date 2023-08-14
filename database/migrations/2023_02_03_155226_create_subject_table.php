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
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string("name")->unique();
            $table->enum("status", [0, 1])->default(1);
            $table->string('image');
            $table->foreignId("academic_year_id")->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId("semester_id")->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId("branch_id")->constrained()->cascadeOnDelete()->cascadeOnUpdate();
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
        Schema::dropIfExists('subjects');
    }
};
