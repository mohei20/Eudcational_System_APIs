<?php

namespace Database\Seeders;

use Faker\Factory;
use App\Models\Exam;
use App\Models\Option;
use App\Models\Question;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OptionSeeder extends Seeder
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
        $questionsIds = Question::pluck('id');

        for ($i = 0; $i < 50; $i++) {
            Option::create([
                'option' => $faker->text,
                'is_correct' => $faker->boolean(50),
                'exam_id' => $examsIds[rand(0, count($examsIds) - 1)],
                'question_id' => $questionsIds[rand(0, count($questionsIds) - 1)]
            ]);
        }
    }
}
