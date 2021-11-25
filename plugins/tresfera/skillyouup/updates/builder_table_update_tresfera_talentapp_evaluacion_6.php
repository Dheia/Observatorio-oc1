<?php namespace Tresfera\Skillyouup\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaSkillyouupEvaluacion6 extends Migration
{
    public function up()
    {
        Schema::table('tresfera_skillyouup_evaluacion', function($table)
        {
            $table->integer('tipo');
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_skillyouup_evaluacion', function($table)
        {
            $table->dropColumn('tipo');
        });
    }
}
