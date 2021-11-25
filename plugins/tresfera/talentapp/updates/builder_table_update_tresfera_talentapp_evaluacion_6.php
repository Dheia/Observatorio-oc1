<?php namespace Tresfera\Talentapp\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaTalentappEvaluacion6 extends Migration
{
    public function up()
    {
        Schema::table('tresfera_talentapp_evaluacion', function($table)
        {
            $table->integer('tipo');
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_talentapp_evaluacion', function($table)
        {
            $table->dropColumn('tipo');
        });
    }
}
