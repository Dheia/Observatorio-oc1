<?php namespace Tresfera\Talentapp\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaTalentappEvaluacion18 extends Migration
{
    public function up()
    {
        Schema::table('tresfera_talentapp_evaluacion', function($table)
        {
            $table->integer('client_id')->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_talentapp_evaluacion', function($table)
        {
            $table->integer('client_id')->nullable(false)->change();
        });
    }
}
