<?php namespace Tresfera\Talent\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaTalentProyecto extends Migration
{
    public function up()
    {
        Schema::table('tresfera_talent_proyecto', function($table)
        {
            $table->integer('estado_informe')->default(0);
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_talent_proyecto', function($table)
        {
            $table->dropColumn('estado_informe');
        });
    }
}
