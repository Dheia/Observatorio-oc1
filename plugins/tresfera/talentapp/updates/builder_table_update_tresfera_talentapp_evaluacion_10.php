<?php namespace Tresfera\Talentapp\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaTalentappEvaluacion10 extends Migration
{
    public function up()
    {
        Schema::table('tresfera_talentapp_evaluacion', function($table)
        {
            $table->text('name');
            $table->text('username');
            $table->text('password');
            $table->text('email');
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_talentapp_evaluacion', function($table)
        {
            $table->dropColumn('name');
            $table->dropColumn('username');
            $table->dropColumn('password');
            $table->dropColumn('email');
        });
    }
}
