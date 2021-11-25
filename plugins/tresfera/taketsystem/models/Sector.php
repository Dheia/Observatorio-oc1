<?php

namespace Tresfera\Taketsystem\Models;

use Model;
use DB;
/**
 * QuizType Model.
 */
class Sector extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'tresfera_taketsystem_sectors';

    /**
     * @var array Fillable fields
    */
    protected $fillable = ['*'];
  
    /**
     * Has Many relations.
     *
     * @var array
     */
    public $hasMany = [
        'sections'  => ['Tresfera\Taketsystem\Models\Section'],
        'questions'  => ['Tresfera\Taketsystem\Models\Question'],
    ];
	public $implement = ['RainLab.Translate.Behaviors.TranslatableModel'];	
    public $translatable = ['title'];    
    /**
     * @var array Cache for nameList() method
     */
    protected static $nameList = null;
    public static function getNameList()
    {
        if (self::$nameList)
            return self::$nameList;
        return self::$nameList = self::isEnabled()->lists('name', 'id');
    }
}
