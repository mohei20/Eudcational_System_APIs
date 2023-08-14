<?php

namespace Database\Seeders;

use Faker\Factory;
use App\Models\User;
use App\Models\Branch;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'manager']);
        Role::create(['name' => 'head_of_branch']);
        Role::create(['name' => 'assistant']);

        $faker = Factory::create();


        for ($i=0; $i < 3 ; $i++) {
            $headOfManager = User::create([
                'name' => $faker->name,
                'email' => $faker->unique->email,
                'password' => Hash::make('123456')
            ]);
            $headOfManager->assignRole('head_of_branch');
        }


        $ids = User::role('head_of_branch')->pluck('id');
        for ($i=0; $i < 3 ; $i++) {
            Branch::create([
                'name' => $faker->name(),
                'address' => $faker->address(),
                'phone_number' => '01143124020',
                'hot_line' => '1234',
                'map_location' => '<iframe src="https://www.google.com/maps/embed?pb=!1m10!1m8!1m3!1d7097.931954450119!2d31.1065821!3d27.1888061!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sar!2seg!4v1674600272097!5m2!1sar!2seg"
                    width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
                'status' => 1,
                'user_id' => $ids[rand(0, count($ids)-1)]
            ]);
        }

    }
}
