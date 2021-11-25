<?php namespace Tresfera\Talent\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaTalentProyectosGestores extends Migration
{
    public function up()
    {
        Schema::table('tresfera_talent_proyectos_gestores', function($table)
        {
            $table->renameColumn('user_id', 'gestor_id');
            $table->dropColumn('name');
            $table->dropColumn('email');
            $table->dropColumn('password');
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_talent_proyectos_gestores', function($table)
        {
            $table->renameColumn('gestor_id', 'user_id');
            $table->string('name', 191);
            $table->string('email', 191);
            $table->string('password', 191);
        });
    }
}
