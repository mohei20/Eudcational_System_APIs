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
        Schema::create('orders',function(Blueprint $table){
            $table->id();
            $table->enum('status', [1,2,3,4,5,6,7])->default(1);
            $table->double('sub_total');
            $table->double('discount')->default(null);
            $table->double('shipping')->default(null);
            $table->double('tax');
            $table->double('total');
            $table->string('expire_month');
            $table->string('expire_year');
            $table->string('name_on_card');
            $table->bigInteger('number_on_card');
            $table->integer('cvc');
            $table->foreignId('student_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
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
        Schema::dropIfExists('orders');
    }
};
