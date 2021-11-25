<?php namespace Tresfera\Taketsystem\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaTaketsystemResults3 extends Migration
{
    public function up()
    {
        Schema::table('tresfera_taketsystem_results', function($table)
        {
            $table->string('genero')->nullable();
            $table->string('sector')->nullable();
            $table->string('edad')->nullable();
            $table->string('area')->nullable();
            $table->string('funcion')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_taketsystem_results', function($table)
        {
            $table->dropColumn('genero');
            $table->dropColumn('sector');
            $table->dropColumn('edad');
            $table->dropColumn('area');
            $table->dropColumn('funcion');
        });
    }
}
