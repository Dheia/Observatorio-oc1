<?php namespace Tresfera\Skillyouup\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaSkillyouupEvaluacion3 extends Migration
{
    public function up()
    {
        Schema::table('tresfera_skillyouup_evaluacion', function($table)
        {
            $table->integer('evaluador_id')->unsigned();
            $table->integer('proyecto_id')->unsigned()->change();
            $table->integer('evaluado_id')->unsigned()->change();
            $table->integer('cuestionario_evaluado_id')->unsigned()->change();
            $table->integer('cuestionario_evaluador_id')->unsigned()->change();
            $table->dropColumn('evaluadores');
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_skillyouup_evaluacion', function($table)
        {
            $table->dropColumn('evaluador_id');
            $table->integer('proyecto_id')->unsigned(false)->change();
            $table->integer('evaluado_id')->unsigned(false)->change();
            $table->integer('cuestionario_evaluado_id')->unsigned(false)->change();
            $table->integer('cuestionario_evaluador_id')->unsigned(false)->change();
            $table->text('evaluadores')->nullable();
        });
    }
}
