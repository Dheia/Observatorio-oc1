<?php namespace Tresfera\Talent\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaTalentEvaluacion2 extends Migration
{
    public function up()
    {
        Schema::table('tresfera_talent_evaluacion', function($table)
        {
            $table->integer('estado')->default(1);
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_talent_evaluacion', function($table)
        {
            $table->dropColumn('estado');
        });
    }
}
