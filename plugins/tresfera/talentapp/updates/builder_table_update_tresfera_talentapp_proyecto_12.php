<?php namespace Tresfera\Talentapp\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaTalentappProyecto12 extends Migration
{
    public function up()
    {
        Schema::table('tresfera_talentapp_proyecto', function($table)
        {
            $table->string('email', 191)->nullable()->change();
            $table->string('periodicidad')->change();
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_talentapp_proyecto', function($table)
        {
            $table->string('email', 191)->nullable(false)->change();
            $table->string('periodicidad', 191)->change();
        });
    }
}
