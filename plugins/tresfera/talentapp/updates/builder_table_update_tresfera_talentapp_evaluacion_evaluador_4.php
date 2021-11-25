<?php namespace Tresfera\Talentapp\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaTalentappEvaluacionEvaluador4 extends Migration
{
    public function up()
    {
        Schema::table('tresfera_talentapp_evaluacion_evaluador', function($table)
        {
          //  $table->renameColumn('evaluac', 'eval');
         //   $table->primary(['eval','evaluador']);
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_talentapp_evaluacion_evaluador', function($table)
        {
         //   $table->dropPrimary(['eval','evaluador']);
          //  $table->renameColumn('eval', 'evaluac');
        });
    }
}
