<?php namespace Tresfera\Taketsystem\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaTaketsystemResults extends Migration
{
    public function up()
    {
        Schema::table('tresfera_taketsystem_results', function($table)
        {
            $table->boolean('is_autoevaluacion')->default(0);
            $table->boolean('is_evaluacion')->default(0);
            $table->string('sex')->nullable();
            $table->string('age')->nullable();
            $table->string('email')->nullable();
            $table->string('free')->nullable();
            $table->string('cp')->nullable();
            $table->integer('evaluacion_id')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_taketsystem_results', function($table)
        {
            $table->dropColumn('is_autoevaluacion');
            $table->dropColumn('is_evaluacion');
            $table->dropColumn('sex');
            $table->dropColumn('age');
            $table->dropColumn('email');
            $table->dropColumn('free');
            $table->dropColumn('cp');
            $table->dropColumn('evaluacion_id');
        });
    }
}
