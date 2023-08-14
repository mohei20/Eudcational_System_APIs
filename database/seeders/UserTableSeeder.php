<?php

namespace Database\Seeders;

use Faker\Factory;
use App\Models\User;
use App\Models\Branch;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Factory::create();


        $mananger = User::create([
            'name' => 'mahmoud',
            'email' => 'mahmoud@gmail.com',
            'password' => Hash::make('123456')
        ]);
        $mananger->assignRole('manager');


        for ($i=0; $i < 6 ; $i++) {
            $assistant = User::create([
                'name' => $faker->name,
                'email' => $faker->unique->email,
                'password' => Hash::make('123456')
            ]);
            $assistant->assignRole('assistant');
            $branch = Branch::status()->pluck('id');
            $assistant->branch()->attach([
                $branch[rand(0, count($branch)-1)]
            ], [
                'from' => $faker->time(),
                'to' => $faker->time(),
                'salary' => rand(100, 5000)
            ]);
        }

    }
}
