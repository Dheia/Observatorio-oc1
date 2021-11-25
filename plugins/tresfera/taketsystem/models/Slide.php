<?php

namespace Tresfera\Taketsystem\Models;

use Model;
use Config;
use Cms\Classes\Page;
use Cms\Classes\Theme;
use Cms\Classes\Controller as CmsController;
use October\Rain\Parse\Bracket as TextParser;
use October\Rain\Parse\Twig;
use Backend\Classes\Controller;

use Twig_Environment;
use Twig_Cache_Filesystem;
use Cms\Twig\Loader as TwigLoader;
use Cms\Classes\Layout;
/**
 * Slide Model.
 */
class Slide extends Model
{
    use \October\Rain\Parse\Syntax\SyntaxModelTrait;
    use \October\Rain\Database\Traits\Validation;
    use \System\Traits\AssetMaker;
    use \October\Rain\Database\Traits\Revisionable; 
    // Add  for revisions limit
    public $revisionableLimit = 2000; 

            // Add for revisions on particular field
    protected $revisionable = ["id","quiz_id","type_id","page","name","syntax_data","syntax_fields","campos"];



    public $morphMany = [
        'revision_history' => ['System\Models\Revision', 'name' => 'revisionable']
    ];
    /**
     * @var string The database table used by the model.
     */
    public $table = 'tresfera_taketsystem_slides';

    /**
     * @var array Fillable fields
     */
    protected $fillable = ['page', 'name', 'order'];

    /**
     * @var array Rules
     */
    public $rules = [
        'name'  => 'required',
        'page'  => 'required',
        'order' => 'numeric',
    ];

    /**
     * @var array Default values
     */
    public $attributes = [
        'page'  => 'slides_portada/simple',
    ];

    /**
     * @var array List of attribute names which are json encoded and decoded from the database.
     */
     protected $jsonable = ['syntax_data', 'syntax_fields', 'view', 'campo', 'campos'];

    /**
     * Belongs To relations.
     *
     * @var array
     */
    public $belongsTo = [
        'quiz' => ['Tresfera\Taketsystem\Models\Quiz'],
        'type' => ['Tresfera\Taketsystem\Models\SlideType', 'key' => 'type_id', 'order' => 'id'],
    ];

    public $belongsToMany = [
        'devices' => [
            'Tresfera\Taketsystem\Models\Device',
            'table' => 'tresfera_taketsystem_quiz_devices',
            'timestamps' => true,
        ],
        'segmentaciones' => [
            'Tresfera\Taketsystem\Models\Device',
            'table' => 'tresfera_taketsystem_quiz_devices',
            'timestamps' => true,
        ],
    ];

    /**
     * @var array Attributes that support translation, if available.
     */
    public $translatable = ['name',"syntax_data[url]","syntax_data[title]","campos","syntax_data[bg]","syntax_data[css]"];
    public $implement = ['@RainLab.Translate.Behaviors.TranslatableModel'];


    public function diff(){
        $history = $this->revision_history;
    }
    public function getRevisionableUser()
    {
        if(isset(\BackendAuth::getUser()->id))
            return \BackendAuth::getUser()->id;
    }
    /**
     * Add translation support to this model, if available.
     */
    public static function boot()
    {
        // Call default functionality (required)
        parent::boot();

        // Check the translate plugin is installed
      /*  if (!class_exists('RainLab\Translate\Behaviors\TranslatableModel')) {
            return;
        }

        // Extend the constructor of the model
        self::extend(function ($model) {

            // Implement the translatable behavior
            $model->implement[] = 'RainLab.Translate.Behaviors.TranslatableModel';

        });*/
    }

    /**
     * Before save event.
     */
    public function beforeSave()
    {   
        $syntax_data = $this->syntax_data;
        if(post("Slide[campos]"))
            $this->campos = post("Slide[campos]");
        if(post("Slide[syntax_data][title]"))
            $syntax_data['title'] = post("Slide[syntax_data][title]");
        if(post("Slide[syntax_data][bg]"))
            $syntax_data['bg'] = post("Slide[syntax_data][bg]");
        if(post("Slide[syntax_data][url]"))
            $syntax_data['url'] = post("Slide[syntax_data][url]");
        
        $this->syntax_data = $syntax_data;
        // Rebuild content from page
        $this->rebuildContent();
    }

    public function afterSave()
    {
        //dd(post("Slide[syntax_data][title]"));
        
        
    }

    /**
     * Load content from a page.
     *
     * @param string $pageFile
     *
     * @return string
     */
    public function renderView($pageFile)
    {
        if (!$theme = Theme::getActiveTheme()) {
            throw new CmsException(Lang::get('cms::lang.theme.active.not_found'));
        }

      /*  $theme = Theme::getEditTheme();
        $data = $this->getSyntaxData();
        $result = CmsController::render($pageFile, $data, $theme);

        return $result; */

        return $this->pageView();
    }
    /**
     * Rebuild and sync fields and data.
     */
    protected function rebuildContent()
    {
        $content = [];
        foreach(["ES","EN"] as $lang)
            $content[$lang] = $this->pageView($lang);
        
        $this->view = $content;
        $this->content = $this->getPageContent($this->page);
        $this->makeSyntaxFields($this->content);
        return $this;
    }

    /**
     * Load content from a theme page.
     *
     * @param string $page
     *
     * @return string
     */
    protected function getPageContent($page)
    {
        $theme = Theme::getEditTheme();
        $data = $this->getSyntaxData();
        if(!is_array($data)) $data=[];
        $result = CmsController::render($page, $data, $theme);

        return $result;
    }

    /**
     * Returns a list of pages available in the theme.
     *
     * @return array Returns an array of strings.
     */
    public function getPageOptions()
    {
        $result = [];

        $pages = $this->listPagesWithTemplateComponent($this->type);
        foreach ($pages as $baseName => $page) {
            $result[$baseName] = strlen($page->name) ? $page->name : $baseName;
        }

        if (!$result) {
            $result[null] = 'No pages found';
        }

        return $result;
    }

    /**
     * Returns a collection of page objects that use the
     * Campaign Component provided by this plugin.
     *
     * @param int $typeId Slide type ID
     *
     * @return array
     */
    public function listPagesWithTemplateComponent($typeId = 0)
    {
        $result = [];
        $pages = Page::withComponent('taketsystemTemplate')->sortBy('baseFileName')->all();
        
        $type = null;
        if ($typeId) {
            $type = SlideType::find($typeId);
        } else {
            $type = SlideType::first();
        }
        
        foreach ($pages as $page) {
            if(isset($page->settings['type'])) {
                if (! $type || $page->settings['type'] == $type->code) {
                    $baseName = $page->getBaseFileName();
                    $result[$baseName] = $page;
                }
            } 
        }

        return $result;
    }

    /*
    |--------------------------------------------------------------------------
    | Render
    |--------------------------------------------------------------------------
    */
    public function renderPreview()
    {
      if (!$theme = Theme::getActiveTheme()) {
          throw new CmsException(Lang::get('cms::lang.theme.active.not_found'));
      }

    /*  
        $theme = Theme::getEditTheme();
        $data = $this->getSyntaxData();
        $result = CmsController::render($pageFile, $data, $theme);

        return $result; 
    */

      // Parser

      return $this->insertTheme($this->pageView());
    }

    public function pageView($lang="ES") {
        $model = Slide::find($this->id);

        if(!isset($model->syntax_data)) return;
        if($lang != "ES")
            $model->translateContext(strtolower($lang));
        if (!$theme = Theme::getActiveTheme()) {
            throw new CmsException(Lang::get('cms::lang.theme.active.not_found'));
        }

        $view = Page::load($theme, $this->page);
        if(!isset($view->markup)) return;

        $explode = explode("--\r\n",$view->markup);
        if(!isset($explode[1])) {
            $explode = explode("--\n",$view->markup);
        }
        
        $data = $model->syntax_data;

        $data['lang'] = $lang;
        if($lang != "ES") {
            $data['url'] = $model->getTranslateAttribute('syntax_data[url]', strtolower($lang));
            $data['title'] = $model->getTranslateAttribute('syntax_data[title]', strtolower($lang));
            $data['bg'] = $model->getTranslateAttribute('syntax_data[bg]', strtolower($lang));
        }
        
        //$parser = $this->getSyntaxParser($view->markup);
        
        $loader = new TwigLoader;
        //$twig = new Twig_Environment();
        $twig = new Twig_Environment($loader);

        $render = "";
        
        if(!is_array($data))
            $data = [];
        
        //fix obligatorios
        //auto
        if(in_array($this->quiz_id, [3,16] )) {
            $obligatorios = [
                'Sexo', 'Edad', 'País', 
                'Nivel de estudios más alto que ha finalizado',
                'Número total de años trabajados', 
                'Número de total de empresas en las que ha trabajado hasta hoy ', 
                'Número de total de años que ha trabajado en el extranjero',
                'Nivel de responsabilidad actual/último', 
                'Área actual en la que trabaja ', 
                'Sector que mejor se ajusta a su actual/última organización', 
                'Número de total de áreas distintas en las que ha trabajado hasta hoy',
                'Número de total de sectores distintos en las que ha trabajado hasta hoy', 
                'Tamaño de la empresa', 
                'Cuántas personas tiene bajo su responsabilidad ', 
                'Número total de horas anuales dedicadas a su formación',

                'Sex', 'Age', 'Country',
                'Total number of years you have worked abroad',
                'Total number of anual hours dedicated to training',
                'Indicate which industry best fits your current/latest organization ',
                'Total number of years you have been worked until today',
                'Size of the company',
                'Total number of different industries you have worked in until today ',
                'How many people work under your responsibility? ',
                'Total number of companies you have worked for until today',
                'Highest level of studies finished',
                'Current/latest level of responsibility',
                'Total number of different areas you have worked in until today',
                'Current area of work ',
                'Años de experiencia laboral en la institución',
                'Grupo al que pertenece'


            ];
        } elseif(in_array($this->quiz_id, [11,13] )) {
            $obligatorios = [
                'Sexo', 'Edad', 'País','Sex', 'Age', 'Country', 
                'Años de experiencia laboral en la institución',
                'Grupo al que pertenece'
            ];
        }

        //fix prepare selects
        if(isset($data['selects'])) {
            $selects = [];
            $data['obligatorio'] = []; 
            foreach($data['selects'] as $select) {
                if(isset($obligatorios))
                if(in_array($select['segmentacion'],$obligatorios)) {
                    $data['obligatorio'][$select['segmentacion']] = 1;
                }
                $selects[$select['segmentacion']][] = trim($select['option']);
            }
            $data['selects_ok'] = $selects;
            if(isset($data['selects_ok']['Country']))
                asort($data['selects_ok']['Country']);
            
            //fix ocultar segmentaciones
            /*foreach($data['selects'] as $select) {
                if(!in_array($select['segmentacion'],['Sex','Age','Sexo','Edad'])) {
                    unset($data['selects_ok'][$select['segmentacion']]);
                    unset($data['selects'][$select['segmentacion']]);

                }
            }*/
        } 
        
            
        $data['slide_id'] = $this->id;

        if(isset($explode[1]))
            $render = $twig->createTemplate($explode[1])->render($data);

        //sistema de render a traves de campos
        if(count($model->campos) > 0) {
            $partial = "$/tresfera/taketsystem/slides/_datos.htm";
            
            $controller = new Controller();
            $render = $controller->makePartial(
                $partial,
                [
                    'data' 		        => array_merge($data,$model->campos),
                    'slide' 		    => $this,
                    'lang'              => $lang
                ]
                );
        }

        return $render;

    }
    public function pageForm() {
      if (!$theme = Theme::getActiveTheme()) {
          throw new CmsException(Lang::get('cms::lang.theme.active.not_found'));
      }
      $view = Page::load($theme, $this->page);
      $explode = explode("--\r\n",$view->markup);
      return $explode[0];
    }
    /**
     * Render.
     *
     * @return string
     */
    public function render()
    {
        $this->rebuildContent();
        $parser = new TextParser();
        $template = $this->renderTemplate();
        $data = $this->getSyntaxData();
        return $parser->parseString($template,$data);
    }

    /**
     * Render template.
     *
     * @return string
     */
    public function renderTemplate()
    {
        // Parser
        $parser = $this->getSyntaxParser($this->content);
        $data = $this->getSyntaxData();

        // Data
        $template = $parser->render($data);

        // Assets
        $template = str_replace('<!--[%styles%]-->', $this->renderClientAssets(), $template);

        return $template;
    }

    /**
     * Render all avariable assets.
     *
     * @return string
     */
    public function renderClientAssets()
    {
        // Style
        if (isset($this->quiz->client->id)) {
            $this->loadAsset('css/clients/'.$this->quiz->client->id.'.css');

            return $this->makeAssets();
        }
    }

    /**
     * Load asset.
     *
     * @param string $path
     */
    public function loadAsset($path)
    {
        $path = '/themes/'.Config::get('cms.activeTheme').'/assets/'.$path;
        if (file_exists(base_path().$path)) {
            $this->addCss($path);
        }
    }

    public function insertTheme($render) {
      return '<!DOCTYPE html>
      <html>
        <head>
          <meta charset="utf-8">
          <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no, width=device-width">
          <title>{{ this.page.title }}</title>


          <script src="//talentapp360.taket.es/themes/slides/assets/tablet/js/lib/ionic/js/ionic.bundle.js"></script>

           <!-- cordova script (this will be a 404 during development) -->
           <script src="//talentapp360.taket.es/themes/slides/assets/tablet/js/cordova.js"></script>

           <script src="//talentapp360.taket.es/themes/slides/assets/tablet/js/app.js"></script>
           <script src="//talentapp360.taket.es/themes/slides/assets/tablet/js/controllers.js"></script>
           <script src="//talentapp360.taket.es/themes/slides/assets/tablet/js/services.js"></script>
           <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
           <script src="//talentapp360.taket.es/themes/slides/assets/tablet/js/taketsystem.js"></script>

       	<link href="//talentapp360.taket.es/themes/slides/assets/tablet/css/ionic.app.css" rel="stylesheet">
           <link href="//talentapp360.taket.es/themes/slides/assets/tablet/css/style.css" rel="stylesheet">
           <link href="http://fonts.googleapis.com/css?family=Merriweather+Sans:400,700,300,800&subset=latin,latin-ext" rel="stylesheet" type="text/css">


        </head>
        <body ng-app="starter">
          <section class="home-container">
      	    '.$render.'
          </section>
          </ion-nav-view>
        </body>
      </html>';

    }
    public function scopeIsMobile($q){
      return $q;
      return $q->whereRaw("page <> 'slides/segmentacion' AND page <> 'slides/informacion'");
      }

      public function scopeIsMulti($q){
      return $q->whereRaw("page <> 'slides/portada'");
      }
}
