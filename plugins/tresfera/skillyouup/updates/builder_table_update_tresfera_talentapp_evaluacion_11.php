<?php namespace Tresfera\Skillyouup\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaSkillyouupEvaluacion11 extends Migration
{
    public function up()
    {
        Schema::table('tresfera_skillyouup_evaluacion', function($table)
        {
            $table->text('tipo')->nullable()->unsigned(false)->default(null)->change();
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_skillyouup_evaluacion', function($table)
        {
            $table->integer('tipo')->nullable()->unsigned(false)->default(null)->change();
        });
    }
}
