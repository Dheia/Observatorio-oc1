<?php

namespace Tresfera\Taketsystem\Updates;

use Schema;
use DB;
use October\Rain\Database\Updates\Migration;

class CreateRegionsCpTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('tresfera_taketsystem_regions_cp')) {
            DB::unprepared(file_get_contents('plugins/tresfera/taketsystem/utils/regions_cp.sql'));
        }
    }

    public function down()
    {
        Schema::dropIfExists('tresfera_taketsystem_regions_cp');
    }
}
