<?php

namespace Database\Seeders;

use App\Models\Attachment;
use Faker\Factory;
use App\Models\ClassRoom;
use Illuminate\Database\Seeder;

class AttachmentSeeder extends Seeder
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

        for ($i = 0; $i < 15; $i++) {
            Attachment::create([
                'name' => 'file.pdf',
                'description' => $faker->unique()->word(),
                'class_room_id' => $classRoomsIds[rand(0, count($classRoomsIds) - 1)]
            ]);
        }
    }
}
