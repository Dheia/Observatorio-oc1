<?php namespace Tresfera\Talent\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaTalentAnswers extends Migration
{
    public function up()
    {
        Schema::table('tresfera_talent_answers', function($table)
        {
            $table->string('question_id', 200)->nullable(false)->unsigned(false)->default(null)->change();
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_talent_answers', function($table)
        {
            $table->integer('question_id')->nullable(false)->unsigned()->default(null)->change();
        });
    }
}
