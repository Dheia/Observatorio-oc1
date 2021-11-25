<?php namespace Tresfera\Taketsystem\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaTaketsystemQuizzes9 extends Migration
{
    public function up()
    {
        Schema::table('tresfera_taketsystem_quizzes', function($table)
        {
            $table->string('dessign_width', 191)->nullable()->change();
            $table->string('dessign_heigth', 191)->nullable()->change();
            $table->string('dessign_background', 191)->nullable()->change();
            $table->string('dessign_radius', 191)->nullable()->change();
            $table->string('dessign_radius_color', 191)->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_taketsystem_quizzes', function($table)
        {
            $table->string('dessign_width', 191)->nullable(false)->change();
            $table->string('dessign_heigth', 191)->nullable(false)->change();
            $table->string('dessign_background', 191)->nullable(false)->change();
            $table->string('dessign_radius', 191)->nullable(false)->change();
            $table->string('dessign_radius_color', 191)->nullable(false)->change();
        });
    }
}
