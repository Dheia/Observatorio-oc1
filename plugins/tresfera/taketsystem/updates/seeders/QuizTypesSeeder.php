<?php

namespace Tresfera\Taketsystem\Updates\Seeders;

use Seeder;
use DB;
use Tresfera\Taketsystem\Models\QuizType;

class QuizTypesSeeder extends Seeder
{
    public function run()
    {
        DB::table('tresfera_taketsystem_quiz_types')->truncate();

        $type = new QuizType();
        $type->name = 'Lógicas';
        $type->save();

        $type = new QuizType();
        $type->name = 'Liniales';
        $type->save();

        $type = new QuizType();
        $type->name = 'Mis plantillas';
        $type->save();
    }
}
