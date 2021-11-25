<?php namespace Tresfera\Talent\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaTalentGestores extends Migration
{
    public function up()
    {
        Schema::table('tresfera_talent_gestores', function($table)
        {
            $table->text('password');
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_talent_gestores', function($table)
        {
            $table->dropColumn('password');
        });
    }
}
