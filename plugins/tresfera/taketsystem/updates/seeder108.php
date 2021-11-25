<?php namespace Tresfera\Taketsystem\Updates;

use Seeder;
use DB;
use Tresfera\TaketSystem\Models\SlideType;

class Seeder108 extends Seeder
{
    public function run()
    {
      DB::table('tresfera_taketsystem_slide_types')->truncate();

        $type = new SlideType();
        $type->name = 'Portada';
        $type->code = 'portada';
        $type->save();
		
        $type = new SlideType();
        $type->name = 'Segmentación';
        $type->code = 'segmentacion';
        $type->save();

        $type = new SlideType();
        $type->name = 'Excelencia';
        $type->code = 'excelencia';
        $type->save();

        $type = new SlideType();
        $type->name = 'Investigación';
        $type->code = 'investigacion';
        $type->save();

        $type = new SlideType();
        $type->name = 'Lógica';
        $type->code = 'logica';
        $type->save();

        $type = new SlideType();
        $type->name = 'Videos';
        $type->code = 'videos';
        $type->save();

        $type = new SlideType();
        $type->name = 'Preguntas';
        $type->code = 'preguntas';
        $type->save();

        $type = new SlideType();
        $type->name = 'Ventas';
        $type->code = 'ventas';
        $type->save();
    }
}