<?php

namespace Tresfera\Taketsystem\Updates\Seeders;

use Seeder;
use DB;
use Faker\Factory;
use Tresfera\Taketsystem\Models\Result;
use Tresfera\Taketsystem\Models\Answer;
use Tresfera\Taketsystem\Models\Quiz;
use Tresfera\Taketsystem\Models\Device;

class ResultssSeeder extends Seeder
{
    public function run()
    {
        DB::table('tresfera_taketsystem_results')->truncate();
        DB::table('tresfera_taketsystem_answers')->truncate();

        $faker = Factory::create();

        foreach (Quiz::all() as $quiz) {
            foreach ($quiz->devices as $device) {

                // Create a new result
                $result = new Result();
                $result->device()->associate($device);
                $result->quiz()->associate($quiz);
                $result->save();

                // Answers
                foreach ($quiz->slides as $slide) {

                    // Don't really care about how many questions the slide has...
                    for ($i = 0; $i <= rand(1, 2); $i++) {

                        // Create a new answer
                        $answer = new Answer();
                        $answer->result()->associate($result);
                        $answer->slide()->associate($slide);
                        $answer->question_number = $i;
                        $answer->question_title = $faker->sentence;
                        $answer->question_type = rand(1, 3);
                        $answer->value = $faker->word;

                        $answer->save();
                    }
                }
            }
        }
    }
}
