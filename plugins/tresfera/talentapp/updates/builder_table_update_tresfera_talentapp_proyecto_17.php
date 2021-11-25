<?php namespace Tresfera\Talentapp\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaTalentappProyecto17 extends Migration
{
    public function up()
    {
        Schema::table('tresfera_talentapp_proyecto', function($table)
        {
            $table->string('periodicidad')->change();
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_talentapp_proyecto', function($table)
        {
            $table->string('periodicidad', 191)->change();
        });
    }
}
