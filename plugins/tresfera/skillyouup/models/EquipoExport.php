<?php namespace Tresfera\Skillyouup\Models;

//use Tresfera\Skillyouup\Models\Equipo;

use Backend\Models\User;

class EquipoExport extends \Backend\Models\ExportModel
{
    public function exportData($columns, $sessionKey = null)
    {
        $evaluaciones = Equipo::all();
        $evaluaciones->each(function($evaluacion) use ($columns) {
            $evaluacion->addVisible($columns);
        });
        print_r($columns);
        dd($evaluaciones->toArray());
        return $evaluaciones->toArray();
    }
}