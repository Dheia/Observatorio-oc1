<?php namespace Tresfera\Taketsystem\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaTaketsystemQuizzes8 extends Migration
{
    public function up()
    {
        Schema::table('tresfera_taketsystem_quizzes', function($table)
        {
            $table->string('dessign_width')->default('1200');
            $table->string('dessign_heigth')->default('680');
            $table->string('dessign_background')->default('#ffffff');
            $table->string('dessign_radius')->default('0');
            $table->string('dessign_radius_color')->default('#000');
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_taketsystem_quizzes', function($table)
        {
            $table->dropColumn('dessign_width');
            $table->dropColumn('dessign_heigth');
            $table->dropColumn('dessign_background');
            $table->dropColumn('dessign_radius');
            $table->dropColumn('dessign_radius_color');
        });
    }
}
