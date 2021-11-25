<?php
use Tresfera\Statistics\Models\Rapport;
use Renatio\DynamicPDF\Models\PDFTemplate;
use Tresfera\Statistics\Models\RapportPeriod;

Route::get('/informes/{md5}', function ($md5) {
	try
    {
        $model = Rapport::where("md5","=",$md5)->first();
				$data = $model->data;
    

      /*  $rapport = $model;

        if(isset($rapport->rapportperiod_id)) {
          $rapportPeriod = RapportPeriod::find($rapport->rapportperiod_id);

          $newRapport = new Rapport();
          $newRapport->client_id  				= $rapport->client_id;
          $newRapport->theme		  				= $rapport->theme	;
          $newRapport->type							  = $rapport->type;
          $newRapport->filters						= $rapportPeriod->filters;
          $newRapport->rapportperiod_id	  = $rapport->rapportperiod_id;
          $newRapport->date_start 				= $rapport->date_start;
          $newRapport->date_end 					= $rapport->date_end ;
          $newRapport->datelast_start 		= $rapport->datelast_start;
          $newRapport->datelast_end   		= $rapport->datelast_end;

          $newRapport->save();
          $data = $newRapport->data;
          dd($data);

        }*/
    
    
				$data['filters'] = $model->filters;
        return PDFTemplate::render($model->theme, $data);
    } catch (Exception $ex)
    {

        return "Error: Ningún informe";
    }
});
