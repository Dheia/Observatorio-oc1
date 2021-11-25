<?php namespace Tresfera\Taketsystem\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaTaketsystemAnswers2 extends Migration
{
    public function up()
    {
        Schema::table('tresfera_taketsystem_answers', function($table)
        {
            $table->integer('duplicated')->nullable()->default(0);
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_taketsystem_answers', function($table)
        {
            $table->dropColumn('duplicated');
        });
    }
}
