<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ids=Order::pluck('id');
        for ($i=0; $i < 3 ; $i++) {
           
            Transaction::create([
               
                'status' => 1,
                'order_id'=>$ids[rand(0,count($ids)-1)]
                
            ]);
    }
    }
}
