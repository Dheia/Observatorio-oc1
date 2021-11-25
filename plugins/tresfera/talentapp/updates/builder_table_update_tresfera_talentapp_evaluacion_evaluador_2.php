<?php namespace Tresfera\Talentapp\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaTalentappEvaluacionEvaluador2 extends Migration
{
    public function up()
    {


        Schema::table('tresfera_talentapp_evaluacion_evaluador', function($table)
        {
           // $table->dropPrimary(['ev','evr']);
            $table->renameColumn('evr', 'evaluador');
        //    $table->primary(['ev','evaluador']);
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_talentapp_evaluacion_evaluador', function($table)
        {
         //   $table->dropPrimary(['ev','evaluador']);
            $table->renameColumn('evaluador', 'evr');
          //  $table->primary(['ev','evr']);
        });
    }
}
