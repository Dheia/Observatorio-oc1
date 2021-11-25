<?php namespace Tresfera\Taketsystem\Models;

use Model;

/**
 * SegmentacionValor Model
 */
class SegmentacionValue extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'tresfera_taketsystem_segmentacion_valors';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [
        'segmentacion' => ['Tresfera\Taketsystem\Models\Segmentacion'],
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachMany = [];
  
    public $implement = ['RainLab.Translate.Behaviors.TranslatableModel'];	
    public $translatable = ['value']; 
    public $attachOne = [
        'image' => 'System\Models\File',
        'image_en' => 'System\Models\File',
        'image_ca' => 'System\Models\File'
    ];
}