<?php namespace Tresfera\Talent\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaTalentEvaluacion extends Migration
{
    public function up()
    {
        Schema::table('tresfera_talent_evaluacion', function($table)
        {
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->string('name')->change();
            $table->string('password')->change();
            $table->string('email')->change();
            $table->string('lang')->change();
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_talent_evaluacion', function($table)
        {
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
            $table->string('name', 191)->change();
            $table->string('password', 191)->change();
            $table->string('email', 191)->change();
            $table->string('lang', 191)->change();
        });
    }
}
