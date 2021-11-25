<?php namespace Tresfera\Buildyouup\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaBuildyouupEvaluacion11 extends Migration
{
    public function up()
    {
        Schema::table('tresfera_buildyouup_evaluacion', function($table)
        {
            $table->text('tipo')->nullable()->unsigned(false)->default(null)->change();
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_buildyouup_evaluacion', function($table)
        {
            $table->integer('tipo')->nullable()->unsigned(false)->default(null)->change();
        });
    }
}
