<?php

namespace Database\Seeders;

use Faker\Factory;
use App\Models\ClassRoom;
use App\Models\Exam;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ExamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        $classRoomsIds = ClassRoom::pluck('id');
        $status  = ['0','1'];

        for ($i = 0; $i < 50; $i++) {
            Exam::create([
                'name' => $faker->name,
                'description' => $faker->text,
                'start_at' => $faker->dateTime(),
                'end_at' => $faker->dateTime(),
                'class_room_id' => $classRoomsIds[rand(0, count($classRoomsIds) - 1)],
                // 'status' =>  $status[rand(0, count($status) - 1)],
            ]);
        }
    }
}
