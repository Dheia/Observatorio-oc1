<?php

namespace Tresfera\Taketsystem\Updates\Seeders;

use Seeder;
use DB;
use Tresfera\Taketsystem\Models\QuestionType;

class QuestionTypesSeeder extends Seeder
{
    public function run()
    {
        DB::table('tresfera_taketsystem_question_types')->truncate();

        $type = new QuestionType();
        $type->name = 'Opciones';
        $type->save();

        $type = new QuestionType();
        $type->name = 'Texto';
        $type->save();

        $type = new QuestionType();
        $type->name = 'Área de texto';
        $type->save();
    }
}
