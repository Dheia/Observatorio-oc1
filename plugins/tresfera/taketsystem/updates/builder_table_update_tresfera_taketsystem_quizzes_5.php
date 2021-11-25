<?php namespace Tresfera\Taketsystem\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaTaketsystemQuizzes5 extends Migration
{
    public function up()
    {
        Schema::table('tresfera_taketsystem_quizzes', function($table)
        {
            $table->string('custom_css');
            $table->string('style_title_bg')->change();
            $table->string('style_title_text')->change();
            $table->string('style_button_bg')->change();
            $table->string('style_button_text')->change();
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_taketsystem_quizzes', function($table)
        {
            $table->dropColumn('custom_css');
            $table->string('style_title_bg', 191)->change();
            $table->string('style_title_text', 191)->change();
            $table->string('style_button_bg', 191)->change();
            $table->string('style_button_text', 191)->change();
        });
    }
}
