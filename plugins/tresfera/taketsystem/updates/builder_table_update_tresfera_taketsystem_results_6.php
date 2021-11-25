<?php namespace Tresfera\Taketsystem\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaTaketsystemResults6 extends Migration
{
    public function up()
    {
        Schema::table('tresfera_taketsystem_results', function($table)
        {
            $table->integer('evaluacion_id')->nullable(false)->default(0)->change();
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_taketsystem_results', function($table)
        {
            $table->integer('evaluacion_id')->nullable()->default(null)->change();
        });
    }
}
