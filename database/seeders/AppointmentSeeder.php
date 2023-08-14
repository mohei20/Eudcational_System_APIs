<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\ClassRoom;
use Faker\Factory;
use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
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

        for ($i = 0; $i < 10; $i++) {
            Appointment::create([
                'day' => rand(1, 7),
                'from' => $faker->time('H:i'),
                'to' => $faker->time('H:i'),
                'class_room_id' => $classRoomsIds[rand(0, count($classRoomsIds) - 1)]
            ]);
        }
    }
}
