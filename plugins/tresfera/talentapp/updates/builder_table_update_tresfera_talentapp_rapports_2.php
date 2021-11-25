<?php namespace Tresfera\Talentapp\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaTalentappRapports2 extends Migration
{
    public function up()
    {
        Schema::table('tresfera_talentapp_rapports', function($table)
        {
            $table->integer('proyecto_id');
            $table->dateTime('global');
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_talentapp_rapports', function($table)
        {
            $table->dropColumn('proyecto_id');
            $table->dropColumn('global');
        });
    }
}
