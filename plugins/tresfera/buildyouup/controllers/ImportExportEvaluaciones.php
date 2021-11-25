<?php namespace Tresfera\Buildyouup\Controllers;

use Lang;
use Backend\Behaviors\ImportExportController;
use League\Csv\AbstractCsv;
use League\Csv\Writer as CsvWriter;
use SplTempFileObject;

use Tresfera\Buildyouup\Models\Proyecto;

class ImportExportEquipos extends ImportExportController
{
    
    public function exportFromList($definition = null, $options = [])
    {
        $lists = $this->controller->makeLists();

        $widget = $lists[$definition] ?? reset($lists);
        /*
         * Parse options
         */
        $defaultOptions = [
            'fileName' => $this->exportFileName,
            'delimiter' => ';',
            'enclosure' => '"'
        ];

        $options = array_merge($defaultOptions, $options);

        /*
         * Prepare CSV
         */
        $csv = CsvWriter::createFromFileObject(new SplTempFileObject);
        $csv->setOutputBOM(AbstractCsv::BOM_UTF8);
        $csv->setDelimiter($options['delimiter']);
        $csv->setEnclosure($options['enclosure']);

        /*
         * Add headers
         */
        $headers = [];
        $columns = $widget->getVisibleColumns();
        foreach ($columns as $column) {
            $headers[] = Lang::get($column->label);
        }
        

        /*
         * Add records
         */
        $getter = $this->getConfig('export[useList][raw]', false)
            ? 'getColumnValueRaw'
            : 'getColumnValue';

        $model = $widget->prepareModel();
        $results = $model->get();

        /*
        $eval_totales = count($results);
        $eval_completadas = 0;
        $eval_pendientes = 0;

        foreach($results as $result)
        {
            $eval_completadas += $result->getContestadas();
            $eval_pendientes += $result->getPendientes();
        }
        */

        $estadisticas = Proyecto::getEstadisticas("tresfera_buildyouup-Administrador_CSV-Filter-listFilter");

        $csv->insertOne("Buildyouup360");
        $csv->insertOne("Proyectos en curso: ".$estadisticas['proyectos_en_curso'] );
        $csv->insertOne("Proyectos finalizados: ".$estadisticas['proyectos_finalizados'] );
        $csv->insertOne("Evaluados activos: ".$estadisticas['evaluados_activos'] );
        $csv->insertOne("Evaluados finalizados: ".$estadisticas['evaluados_finalizadas'] );
        $csv->insertOne("Proyectos finalizados: ".$estadisticas['proyectos_finalizados'] );
        $csv->insertOne("Equipos completadas: ".$estadisticas['evaluaciones_completadas']);
        $csv->insertOne("Equipos pendientes: ".$estadisticas['evaluaciones_pendientes']);
        $csv->insertOne($headers);

        foreach ($results as $result) {
            $record = [];
            foreach ($columns as $column) {
                $value = $widget->$getter($result, $column);
                if (is_array($value)) {
                    $value = implode('|', $value);
                }
                $record[] = $value;
            }
            $csv->insertOne($record);
        }

        /*
         * Output
         */
        $csv->output($options['fileName']);
        exit;
    }
}

