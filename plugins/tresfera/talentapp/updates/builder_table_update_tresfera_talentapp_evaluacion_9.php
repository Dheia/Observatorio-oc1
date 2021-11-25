<?php namespace Tresfera\Talentapp\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaTalentappEvaluacion9 extends Migration
{
    public function up()
    {
        Schema::table('tresfera_talentapp_evaluacion', function($table)
        {
            $table->text('jefe');
            $table->text('companero');
            $table->text('colaborador');
            $table->text('otro');
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_talentapp_evaluacion', function($table)
        {
            $table->dropColumn('jefe');
            $table->dropColumn('companero');
            $table->dropColumn('colaborador');
            $table->dropColumn('otro');
        });
    }
}
