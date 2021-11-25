<?php

namespace Tresfera\Taketsystem\Updates\Seeders;

use Seeder;
use DB;
use Carbon\Carbon;
use Faker\Factory;
use Tresfera\Taketsystem\Models\Client;
use Tresfera\Taketsystem\Models\Quiz;
use Tresfera\Taketsystem\Models\Slide;
use Tresfera\Taketsystem\Models\SlideType;

class QuizzesSeeder extends Seeder
{
    public function run()
    {
        DB::table('tresfera_taketsystem_quizzes')->truncate();
        DB::table('tresfera_taketsystem_quiz_devices')->truncate();
        DB::table('tresfera_taketsystem_slides')->truncate();

        $faker = Factory::create();

        foreach (Client::all() as $client) {
            for ($i = 1; $i <= 2; $i++) {

                // Create a new quiz
                $quiz = new Quiz();
                $quiz->client()->associate($client);
                $quiz->user()->associate($client->users()->orderBy(DB::raw('RAND()'))->first());
                $quiz->title = $faker->sentence;
                $quiz->date_start = Carbon::now()->subYear();
                $quiz->date_end = Carbon::now()->addYear();
                $quiz->save();

                // Create slides
                for ($j = 1; $j <= rand(2, 5); $j++) {
                    $slide = new Slide();
                    $slide->quiz()->associate($quiz);
                    $slide->type()->associate(SlideType::orderBy(DB::raw('RAND()'))->first());
                    $slide->name = $faker->sentence;
                    $slide->order = $j;
                    $slide->save();
                }

                // Add devices
                foreach ($client->devices()->take(30)->get() as $device) {
                    $quiz->devices()->attach($device->id);
                }
            }
        }
    }
}
