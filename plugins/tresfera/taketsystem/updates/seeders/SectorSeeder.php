<?php

namespace Tresfera\Taketsystem\Updates\Seeders;

use Seeder;
use DB;
use Tresfera\Taketsystem\Models\Sector;
use Tresfera\Taketsystem\Models\Section;

/*

Agencias de viajes
Grandes superficies
Ópticas
Centros de salud y belleza
Perfumerías
Congresos y ferias
Entidades financieras
Hoteles
Restaurantes
Comercios

*/

class SectorsSeeder extends Seeder
{
    public function run()
    {
	    
	    $sectors = [
		    "Comercios" => [
			    "General",
			    "Punto de Venta",
			    "Calidad de servicio Dependientes/as",
			    "Nuestros Productos",
			    "Organización y Orden",
			    "Precio y Calidad",
			    "Escaparates",
		    ],
		    "Restaurantes" => [
			    "General",
			    "Cocina/Platos",
			    "Atención y Calidad de servicio",
			    "Decoración,  Diseño y Confort",
			    "Limpieza y Orden",
			    "Precio y Calidad",
		    ],
		    "Hoteles" => [
			    "General",
			    "Atención y Calidad de servicio",
			    "Estancia y Descanso",
			    "Restaurante",
			    "Limpieza y Orden",
			    "Precio y Calidad",
			    "Actividades del hotel",
			    "Recepción"
		    ],
		    "Entidades financieras" => [
			    "General"
			],
			"Congresos y ferias" => [
			    "General"
			],
			"Perfumerías" => [
			    "General"
			],
			"Centros de salud y belleza" => [
			    "General"
			],
			"Ópticas" => [
			    "General"
			],
			"Grandes superficies" => [
			    "General"
			],
			"Agencias de viajes" => [
			    "General"
			],
	    ];
	    
        DB::table('tresfera_taketsystem_sectors')->truncate();
        DB::table('tresfera_taketsystem_sections')->truncate();
		foreach($sectors as $sector_name => $sections) {
			$sector = new Sector();
	        $sector->title = $sector_name;
	        $sector->save();
	        
	        foreach($sections as $section_name) {
		       $section = new Section();
		        $section->title = $section_name;
		        $section->sector()->associate($sector);
		        $section->save(); 
	        }
	        
		}
    }
}
