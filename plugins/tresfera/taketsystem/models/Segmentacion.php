<?php

namespace Tresfera\Taketsystem\Models;

use Model;
use DB;
use Tresfera\Taketsytem\Models\SegmentacionValue;
/**
 * QuizType Model.
 */
class Segmentacion extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'tresfera_taketsystem_segmentacion';

    /**
     * @var array Fillable fields
    */
    protected $fillable = ['*'];
  
    /**
     * Has Many relations.
     *
     * @var array
     */
    public $belongsTo = [
        'client'  => ['Tresfera\Clients\Models\Client'],
    ];
  
    public $hasMany = [
        'values'  => ['Tresfera\Taketsystem\Models\SegmentacionValue'],
    ];
  
  
    public $implement = ['RainLab.Translate.Behaviors.TranslatableModel'];
    public $translatable = ['name','values'];    
    public $jsonable = ['values'];
    /**
     * @var array Cache for nameList() method
     */
    protected static $nameList = null;
  
    public function beforeCreate() {
      $this->slug = str_slug($this->name);
    }
  
    public static function getNameList()
    {
        if (self::$nameList)
            return self::$nameList;
        return self::$nameList = self::isEnabled()->lists('name', 'id');
    }
}
