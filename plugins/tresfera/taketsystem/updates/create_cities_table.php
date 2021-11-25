<?php

namespace Tresfera\Taketsystem\Updates;

use Schema;
use DB;
use October\Rain\Database\Updates\Migration;

class CreateCitiesTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('tresfera_taketsystem_cities')) {
            DB::unprepared(file_get_contents('plugins/tresfera/taketsystem/utils/cities.sql'));
        }
    }

    public function down()
    {
        Schema::dropIfExists('tresfera_taketsystem_cities');
    }
}
