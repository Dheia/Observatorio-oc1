<?php namespace Tresfera\Clients\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaClientsClients2 extends Migration
{
    public function up()
    {
        Schema::table('tresfera_clients_clients', function($table)
        {
            $table->string('name');
            $table->integer('sector_id');
            $table->string('persona_contacto');
            $table->string('telefono');
            $table->string('telefono_alt');
            $table->string('email');
            $table->string('email_alt');
            $table->string('cif');
            $table->string('nombre_fiscal');
            $table->string('direccion');
            $table->string('cp');
            $table->integer('region_id');
            $table->integer('city_id');
            $table->string('cc');
            $table->text('condiciones_comerciales');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_clients_clients', function($table)
        {
            $table->dropColumn('name');
            $table->dropColumn('sector_id');
            $table->dropColumn('persona_contacto');
            $table->dropColumn('telefono');
            $table->dropColumn('telefono_alt');
            $table->dropColumn('email');
            $table->dropColumn('email_alt');
            $table->dropColumn('cif');
            $table->dropColumn('nombre_fiscal');
            $table->dropColumn('direccion');
            $table->dropColumn('cp');
            $table->dropColumn('region_id');
            $table->dropColumn('city_id');
            $table->dropColumn('cc');
            $table->dropColumn('condiciones_comerciales');
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
        });
    }
}
