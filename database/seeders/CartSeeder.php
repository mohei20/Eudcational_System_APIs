<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ids_p=Product::pluck('id');
        $ids_s=Student::pluck('id');

        for ($i=0; $i < 3 ; $i++) {
           
            Cart::create([
                'student_id'=>$ids_s[rand(0,count($ids_s)-1)],
                'product_id'=>$ids_p[rand(0,count($ids_p)-1)],
                'quantity'=>rand(1,400),
                'price'=>rand(100,400),
                'status' => 1,
                
            ]);
    }
}
}
