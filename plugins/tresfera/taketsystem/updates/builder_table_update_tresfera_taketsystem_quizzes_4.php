<?php namespace Tresfera\Taketsystem\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaTaketsystemQuizzes4 extends Migration
{
    public function up()
    {
        Schema::table('tresfera_taketsystem_quizzes', function($table)
        {
            $table->string('style_title_bg');
            $table->string('style_title_text');
            $table->string('style_button_bg');
            $table->string('style_button_text');
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_taketsystem_quizzes', function($table)
        {
            $table->dropColumn('style_title_bg');
            $table->dropColumn('style_title_text');
            $table->dropColumn('style_button_bg');
            $table->dropColumn('style_button_text');
        });
    }
}
