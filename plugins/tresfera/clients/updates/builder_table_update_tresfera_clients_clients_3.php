<?php namespace Tresfera\Clients\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaClientsClients3 extends Migration
{
    public function up()
    {
        Schema::table('tresfera_clients_clients', function($table)
        {
            $table->string('web');
            $table->string('name')->change();
            $table->string('persona_contacto')->change();
            $table->string('telefono')->change();
            $table->string('telefono_alt')->change();
            $table->string('email')->change();
            $table->string('email_alt')->change();
            $table->string('cif')->change();
            $table->string('nombre_fiscal')->change();
            $table->string('direccion')->change();
            $table->string('cp')->change();
            $table->string('cc')->change();
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_clients_clients', function($table)
        {
            $table->dropColumn('web');
            $table->string('name', 191)->change();
            $table->string('persona_contacto', 191)->change();
            $table->string('telefono', 191)->change();
            $table->string('telefono_alt', 191)->change();
            $table->string('email', 191)->change();
            $table->string('email_alt', 191)->change();
            $table->string('cif', 191)->change();
            $table->string('nombre_fiscal', 191)->change();
            $table->string('direccion', 191)->change();
            $table->string('cp', 191)->change();
            $table->string('cc', 191)->change();
        });
    }
}
