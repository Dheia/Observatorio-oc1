<?php namespace Tresfera\Taketsystem\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaTaketsystemProgresos extends Migration
{
    public function up()
    {
        Schema::rename('tresfera_taketsystem_progreso', 'tresfera_taketsystem_progresos');
    }
    
    public function down()
    {
        Schema::rename('tresfera_taketsystem_progresos', 'tresfera_taketsystem_progreso');
    }
}
