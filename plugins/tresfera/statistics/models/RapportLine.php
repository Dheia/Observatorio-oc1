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
class RapportLine extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'tresfera_statistics_rapports_lines';
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
				'rapports' => ['Tresfera\Statistics\Models\Rapport']
		];
    public $belongsTo = [
        'rapport_period'     => ['Tresfera\Statistics\Models\RapportPeriod',['key'=>'rapport_period_id']],
    ];

    public function beforeSave() {
	    //$numSession = "Taket.statistics.filters";
    }

    public function getPeriodAttribute() {
      return $this->datenext_start." - ".$this->datenext_stop;
    }

		public function getDatePeriodNow() {
			return [
				'date_start' => ['start' => $this->datenext_start, 'end' => $this->datenext_stop],
				'date_last' => ['start' => $this->datelast_start, 'end' => $this->datelast_stop]
			];
		}
		public function setNextDates() {


		}
		public function afterCreate() {



		}


}
