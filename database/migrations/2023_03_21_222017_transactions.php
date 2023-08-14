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
        Schema::create('transactions',function(Blueprint $table){
            $table->id();
            $table->enum('status', [1,2,3,4,5,6,7])->default(1)->comment('1 => payment_compelete \n
            2 => out of delivery \n
            3 => cancel_order \n
            4 => done \n
            5 => refund_requested \n
            6 => returned_order \n
            7 => refunded ');
            $table->foreignId('order_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
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
       Schema::dropIfExists('transactions');
    }
};
