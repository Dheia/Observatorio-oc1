<?php namespace Tresfera\Skillyouup\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaSkillyouupRespuestas2 extends Migration
{
    public function up()
    {
        Schema::table('tresfera_skillyouup_respuestas', function($table)
        {
            $table->integer('cuestionario_id')->unsigned()->change();
            $table->integer('user_id')->unsigned()->change();
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_skillyouup_respuestas', function($table)
        {
            $table->integer('cuestionario_id')->unsigned(false)->change();
            $table->integer('user_id')->unsigned(false)->change();
        });
    }
}
