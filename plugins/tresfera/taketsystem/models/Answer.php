<?php

namespace Tresfera\Taketsystem\Models;

use Model;
use DB;

/**
 * Answer Model.
 */
class Answer extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'tresfera_taketsystem_answers';

    /**
     * @var array Fillable fields
     */
    protected $fillable = ['value'];

    /**
     * Belongs To relations.
     *
     * @var array
     */
    public $belongsTo = [
        'result' => ['Tresfera\Taketsystem\Models\Result'],
        'slide'  => ['Tresfera\Taketsystem\Models\Slide'],
    ];

    
    /**
     * Before save event.
     */
    public function beforeSave()
    {
        /*if (isset($this->result->shop->id)) {
            $shop = $this->result->shop()->with('city.region')->first();
            $this->shop()->associate($shop);
            $this->device()->associate($this->result->device);
            $this->city()->associate($shop->city);
            $this->region()->associate($shop->city->region);
        }*/
    }

}
