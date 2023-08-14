<?php

namespace Database\Seeders;

use App\Models\Exam;
use App\Models\Question;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Contracts\Role;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        $examsIds = Exam::pluck('id');

        for ($i = 0; $i < 100; $i++) {
            Question::create([
                'question' => $faker->sentence(15),
                'type' => 2,
                'image' => 'Q1.jpg',
                'point' => $faker->randomFloat(2, 0.5, 10.0),
                'exam_id' => $examsIds[rand(0, count($examsIds) - 1)]
            ]);
        }
    }
}
