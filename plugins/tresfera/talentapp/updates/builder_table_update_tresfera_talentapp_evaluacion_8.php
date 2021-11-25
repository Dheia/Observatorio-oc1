<?php namespace Tresfera\Talentapp\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaTalentappEvaluacion8 extends Migration
{
    public function up()
    {
        Schema::table('tresfera_talentapp_evaluacion', function($table)
        {
            $table->integer('estado')->default(1);
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_talentapp_evaluacion', function($table)
        {
            $table->dropColumn('estado');
        });
    }
}
