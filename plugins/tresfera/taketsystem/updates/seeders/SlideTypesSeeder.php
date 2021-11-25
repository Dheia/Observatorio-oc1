<?php

namespace Tresfera\Taketsystem\Updates\Seeders;

use Seeder;
use DB;
use Tresfera\Taketsystem\Models\SlideType;

class SlideTypesSeeder extends Seeder
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
        $type->name = 'Red';
        $type->code = 'red';
        $type->save();

        $type = new SlideType();
        $type->name = 'Ventas';
        $type->code = 'ventas';
        $type->save();
    }
}
