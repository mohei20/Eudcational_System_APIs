<?php

namespace Database\Seeders;

use App\Models\Shop;
use App\Models\Branch;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ids=Branch::pluck('id');

        for ($i=0; $i < 3 ; $i++) {
            Shop::create([
                'name'=>Str::random(10),
                'branche_id'=>$ids[rand(0,count($ids)-1)]
            ]);
            


        }
    }
}
