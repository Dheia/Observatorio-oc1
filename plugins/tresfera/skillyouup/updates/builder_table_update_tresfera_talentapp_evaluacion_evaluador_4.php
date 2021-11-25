<?php namespace Tresfera\Skillyouup\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaSkillyouupEvaluacionEvaluador4 extends Migration
{
    public function up()
    {
        Schema::table('tresfera_skillyouup_evaluacion_evaluador', function($table)
        {
          //  $table->renameColumn('evaluac', 'eval');
         //   $table->primary(['eval','evaluador']);
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_skillyouup_evaluacion_evaluador', function($table)
        {
         //   $table->dropPrimary(['eval','evaluador']);
          //  $table->renameColumn('eval', 'evaluac');
        });
    }
}
