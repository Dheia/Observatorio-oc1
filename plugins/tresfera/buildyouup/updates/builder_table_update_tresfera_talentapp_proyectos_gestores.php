<?php namespace Tresfera\Buildyouup\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaBuildyouupProyectosGestores extends Migration
{
    public function up()
    {
        Schema::table('tresfera_buildyouup_proyectos_gestores', function($table)
        {
            $table->string('name');
            $table->string('email');
            $table->string('password');
            $table->increments('id')->unsigned(false)->change();
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_buildyouup_proyectos_gestores', function($table)
        {
            $table->dropColumn('name');
            $table->dropColumn('email');
            $table->dropColumn('password');
            $table->increments('id')->unsigned()->change();
        });
    }
}
