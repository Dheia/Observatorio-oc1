<?php

namespace Tresfera\Taketsystem\Models;

use BackendAuth;
use Model;
use RainLab\Translate\Models\Locale;

/**
 * Quiz Model.
 */
class Quiz extends Model
{
   // use \DamianLewis\SortableRelations\Traits\SortableRelations;
    /**
     * @var string The database table used by the model.
     */
    public $table = 'tresfera_taketsystem_quizzes';
    use \October\Rain\Database\Traits\Revisionable; 
    // Add  for revisions limit
    public $revisionableLimit = 2000; 

            // Add for revisions on particular field
    protected $revisionable = ["id",
                                "type_id",
                                "is_template",
                                "client_id",
                                "user_id",
                                "template_id",
                                "template_name",
                                "template_description",
                                "md5",
                                "date_start",
                                "date_end",
                                "desc",
                                "style_header_bg",
                                "style_title_bg",
                                "style_title_text",
                                "style_button_bg",

                                "style_button_text",
                                "custom_css",
                                "dessign_width",
                                "dessign_heigth",

                                "dessign_background",
                                "dessign_radius",
                                "dessign_radius_color",
                                "hidded"
                            ];
    public $morphMany = [
        'revision_history' => ['System\Models\Revision', 'name' => 'revisionable']
    ];
    /**
     * @var array Fillable fields
     */
    protected $fillable = ['title'];

    /**
     * @var array Rules
     */
    public $rules = [
        'title' => 'required',
    ];

    /**
     * Has Many relations.
     *
     * @var array
     */
    public $hasMany = [
        'slides'    =>  [
            'Tresfera\Taketsystem\Models\Slide', 
            'order' => 'order',
            //'conditions' => 'id not in (388,389,390, 290, 480, 481, 482, 291, 293, 294)'
        //  'pivot' => ['order']
        ],
        'slidesQuiz'    =>  [
            'Tresfera\Taketsystem\Models\Slide', 
            'order' => 'order',
            'conditions' => 'hidded = 0'
        //  'pivot' => ['order']
        ],
        'slidesMobile' => ['Tresfera\Taketsystem\Models\Slide', 'order' => 'order', 'scope' => 'isMobile', 
                       //'conditions' => 'id not in (388,389,390, 290, 480, 481, 482, 291, 293, 294)'
                        ],
        'slidesMulti' => ['Tresfera\Taketsystem\Models\Slide', 
                'order' => 'order', 
                'scope' => 'isMulti',
               // 'conditions' => 'id not in (388,389,390, 290, 480, 481, 482, 291, 293, 294)'
            ],

        'results'   => ['Tresfera\Taketsystem\Models\Result'],
        'templates' => ['Tresfera\Taketsystem\Models\Quiz', 'key' => 'template_id'],
    ];

    /**
     * Belongs To relations.
     *
     * @var array
     */
    public $belongsTo = [
        'user'     => ['Backend\Models\User'],
        'client'   => ['Tresfera\Taketsystem\Models\Client'],
        'template' => ['Tresfera\Taketsystem\Models\Quiz',      'key' => 'template_id'],
        'type'     => ['Tresfera\Taketsystem\Models\QuizType',  'key' => 'type_id'],
    ];

    /**
     * File attachments.
     *
     * @var array
     */
    public $attachOne = [
        'cover' => ['System\Models\File'],
        'logo' => ['System\Models\File'],
        'dessign_bg' => ['System\Models\File']
    ];

    /**
     * Belongs To Many relations.
     *
     * @var array
     */
    public $belongsToMany = [
        'devices' => [
            'Tresfera\Taketsystem\Models\Device',
            'table' => 'tresfera_taketsystem_quiz_devices',
            'timestamps' => true,
        ],
        
    ];

    public $jsonable = ['langs'];
    public function getStyles() {
        return $this->custom_css;
    }
    public function diff(){
        $history = $this->revision_history;
    }
    public function getRevisionableUser()
    {
        return \BackendAuth::getUser()->id;
    }
    public function publish() {
    		//updateamos todos los slides
    	  foreach($this->slides as $slide) {
    		  $slide->save();
    	  }
    	}
    public function getLangsOptions($keyValue = null)
    {
        return  Locale::listEnabled();
    }
    public function getUrlAttribute() {
        return url("/quiz/".$this->md5);
    }
    public function getUrlDemoAttribute() {
        return $this->url."?demo=1";
        }
    /**
     * Before create event.
     */
     public function beforeCreate()
    {
        // Current user
        $user = BackendAuth::getUser();

				$this->md5 = md5($this->title.$this->created_at.$this->client_id.rand());

        // Default client = logged client
        if (!isset($this->client->id) && $user && isset($user->client->id)) {
            $this->client()->associate($user->client);
        }

        // Default user = logged user
        if (!$this->user && $user) {
            $this->user()->associate($user);
        }
    }

    /**
     * After create event.
     */
    public function afterCreate()
    {
        // Create from template
        if ($template = $this->template) {
            // Duplicate all slides
            if ($slides = $template->slides) {
                foreach ($slides as $slide) {
                    //$slide->load('questions.options');
                    $newSlide = $slide->replicate();
                    $newSlide->quiz()->associate($this);
                    $newSlide->save();
                }
            }
        }
    }
 
   public function afterUpdate() {
       $this->publish();
   }

    /**
     * Field filter extension.
     *
     * @param object $fields
     * @param string $context
     */
    public function filterFields($fields, $context = null)
    {
        // Permissions
        $user = BackendAuth::getUser();
        if (!$user->hasAccess('tresfera.taketsystem.acces_clients')) {
            $fields->client->hidden = true;
        }
    }

    /**
     * Template type query scope.
     *
     * @param Query $query
     * @param int   $clientId
     *
     * @return Query
     */
    public function scopeIsTemplate($query, $clientId = null)
    {
        return $query->where('is_template', 1)->where(function ($query) use ($clientId) {
            $query->whereNull('client_id')
                  ->orWhere('client_id', $clientId);
        });
    }

    /**
     * Type query scope.
     *
     * @param Query $query
     * @param int   $typeId
     *
     * @return Query
     */
    public function scopeWhereType($query, $typeId = null)
    {
        return $query->where('type_id', $typeId);
    }
}
