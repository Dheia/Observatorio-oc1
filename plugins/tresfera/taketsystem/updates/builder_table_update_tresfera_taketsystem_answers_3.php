<?php namespace Tresfera\Taketsystem\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaTaketsystemAnswers3 extends Migration
{
    public function up()
    {
        Schema::table('tresfera_taketsystem_answers', function($table)
        {
            $table->smallInteger('name');
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_taketsystem_answers', function($table)
        {
            $table->dropColumn('name');
        });
    }
}
