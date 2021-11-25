<?php

namespace Tresfera\Statistics\Models;

use Model;
use System\Models\MailTemplate;
use Backend\Models\User;
use Mail;
use Tresfera\Clients\Models\Client;
use Session;
/**
 * Client Model.
 */
class RapportPeriod extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'tresfera_statistics_rapportsperiod';
    /**
     * @var array Fillable fields
     */
    protected $fillable = ['name', 'max_devices','filters'];
		protected $jsonable = ['emails','filters'];
    /**
     * @var array Rules
     */
    public $rules = [
        'name' => 'required',
    ];

    /**
     * Has Many relations.
     *
     * @var array
     */
    public $hasMany = [
      'rapports' => ['Tresfera\Statistics\Models\Rapport'],
      'rapport_lines' => ['Tresfera\Statistics\Models\RapportLine']
		];
    public $belongsTo = [
        'client'     => ['Tresfera\Clients\Models\Client'],
        'shop'    	 => ['Tresfera\Devices\Models\Shop'],
    ];

    public function beforeSave() {
	    $numSession = "Taket.statistics.filters";
			if(Session::get($numSession) != null)
				$this->filters = (Session::get($numSession));
    }

		public function getDatePeriodNow() {
			return [
				'date_start' => ['start' => $this->datenext_start, 'end' => $this->datenext_stop],
				'date_last' => ['start' => $this->datelast_start, 'end' => $this->datelast_stop]
			];
		}
		public function setNextDates($raportLine = null) {

      if($raportLine != null) {
        $this->datelast_start  = $raportLine->datelast_start;
  			$this->datelast_stop   = $raportLine->datelast_stop;
  			$this->datenext_start  = $raportLine->datenext_start;
  			$this->datenext_stop   = $raportLine->datenext_stop;

        return;
      }
			$day = strtotime('next day',strtotime($this->datenext_stop));
			//echo "\n=============\n".date("Y-m-d",$day)."\n------\n";
			$datelast_start = $this->datenext_start;
			$datelast_stop = $this->datenext_stop;
			switch($this->period) {
					case '1':
						//get Last Monday
						$datenext_start 	= date("Y-m-d",  $day);
						//get Last Sunday
						$datenext_stop 	= date("Y-m-d", strtotime('next Sunday', $day));
					break;
					case '2':
						// primero de mes
						if(date("j", $day)==1) {
							//get Last Monday
							$datenext_start 	= date("Y-m-d",  strtotime('first day of this Month', $day));
							//get Last Sunday
							$datenext_stop 	=  date("Y-m-d",  strtotime('+14 day', strtotime('first day of this Month', $day)));

						} else {
							//get Last Monday
							$datenext_start 	=  date("Y-m-d",  strtotime('+15 day', strtotime('first day of this Month', $day)));
							//get Last Sunday
							$datenext_stop 	= date("Y-m-d",  strtotime('last day of this Month', $day));

						}
					break;
          case '4':
						//get Last Monday
						$datenext_start 	= date("Y-m-d",  strtotime('first day of this Month', $day));
						//get Last Sunday
						$datenext_stop 	= date("Y-m-d", strtotime('last day of this month', $day));
					break;
          case '12':
						//get Last Monday

						$datenext_start 	= date("Y-m-d",  ($day));
						//get Last Sunday
						$datenext_stop 	= date("Y-m-d", strtotime('last day of this month + 3 months', $day));
					break;
				}
		/*	echo $datelast_start."\n";
			echo $datelast_stop."\n";
			echo $datenext_start."\n";
			echo $datenext_stop."\n";*/
			$this->datelast_start = $datelast_start;
			$this->datelast_stop = $datelast_stop;
			$this->datenext_start = $datenext_start;
			$this->datenext_stop = $datenext_stop;

			//dd();
			$this->save();
		}
		public function afterCreate() {

			$user = \BackendAuth::getUser();

			$filters		= $this->filters;
			$date 			= $filters['date_range'];

			if($user->client_id) {
				$client = Client::find($user->client_id);
        $this->client_id = $user->client_id;
        $this->save();
			}

			if(is_array($date['start']))
				$date['start'] = $date['start']['date'];

			$range = (int)((strtotime($date['end']) - strtotime($date['start']))/(60*60*24));


			$date_last['start'] = date("Y-m-d", strtotime($date['start'].' - '.$range.' days'));
				//get Last Sunday
			$date_last['end'] 	= date("Y-m-d", strtotime($date['end'].' - '.($range+2).' days'));


		}


    public function getEmailsTxtAttribute() {
			$emails = [];

			foreach($this->emails as $email) {
				$emails[] = $email['email'];
			}
			return implode(", ", $emails);
		}

}
