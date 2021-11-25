<?php namespace Tresfera\Skillyouup\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaSkillyouupAnswers extends Migration
{
    public function up()
    {
        Schema::table('tresfera_skillyouup_answers', function($table)
        {
            $table->string('question_id', 200)->nullable()->unsigned(false)->default(null)->change();
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_skillyouup_answers', function($table)
        {
            $table->integer('question_id')->nullable(false)->unsigned()->default(null)->change();
        });
    }
}
