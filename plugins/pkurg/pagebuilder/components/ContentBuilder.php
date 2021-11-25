<?php namespace Pkurg\PageBuilder\Components;

use BackendAuth;
use Cms\Classes\ComponentBase;
use Cms\Classes\Content;
use Cms\Classes\Partial;
use File;
use Pkurg\PageBuilder\Models\Settings;
use Request;
use Twig;

class ContentBuilder extends ComponentBase
{

    public $content;
    public $file;
    public $fileMode;
    public $edit;
    public $id;
    public $jsoncontent;

    public function componentDetails()
    {
        return [
            'name' => 'ContentBuilder Component',
            'description' => 'Frontend content builder',
        ];
    }

    public function defineProperties()
    {
        return [
            'savedatato' => [
                'title' => 'Save page data to',
                'type' => 'dropdown',
                'default' => 'content',
                //                'description' => 'If you selected to use content, then you need to add to the page {% component &#x27;ContentBuilder&#x27; %}.  If you selected to use partial, then you need to add to the page
                // {% partial &#x27;mypatrial&#x27; %}',

            ],
            'file' => [
                'title' => 'File',
                'type' => 'dropdown',
                'depends' => ['savedatato'],

            ],

        ];
    }

    public function getSavedatatoOptions()
    {
        return ['content' => 'content', 'partial' => 'partial'];
    }
    public function getFileOptions()
    {

        $Code = Request::input('savedatato');

        if ($Code == 'content') {
            return Content::sortBy('baseFileName')->lists('baseFileName', 'fileName');
        }
        if ($Code == 'partial') {
            return Partial::sortBy('baseFileName')->lists('baseFileName', 'fileName');
        }

    }

    public function onRun()
    {

        // $fileName = 'mypage';
        // $template = Partial::load($this->getTheme(), $fileName);
        // dd($template);

        $this->page['customblocks'] = Settings::get('customblocks');

        $this->id = uniqid();

        $this->edit = $this->isEdit();

        $this->page['curdir'] = url('/');

        // if ($this->edit) {

        //     // $this->addCss('assets/css/editable.css');
        //     // $this->addJs('assets/js/editable.js');

        // }

        $this->file = $this->property('file');
        $this->fileMode = File::extension($this->property('file'));

        if ($this->property('file') == null) {

            $this->content = 'No file';

        } else {

            if ($this->property('savedatato') == 'content') {
                $this->content = $this->renderContent($this->file);
                $this->jsoncontent = json_encode($this->content);
            }

            if ($this->property('savedatato') == 'partial') {
                $this->content = $this->renderPartial($this->file);

                $fileName = $this->file;
                $template = Partial::load($this->getTheme(), $fileName);
                //dd($template->content);

                $this->jsoncontent = json_encode($template->markup);
            }

        }

    }

    public function onSaveFile()
    {
        if (!$this->isEdit()) {
            return;
        }

        $fileName = post('file');

        if ($this->property('savedatato') == 'partial') {
            $template = Partial::load($this->getTheme(), $fileName);
            $template->fill(['markup' => post('content')]);
            $template->save();
        }

        if ($this->property('savedatato') == 'content') {
            $template = Content::load($this->getTheme(), $fileName);
            $template->fill(['markup' => post('content')]);
            $template->save();
        }
    }

    public function isEdit()
    {
        $backendUser = BackendAuth::getUser();
        return $backendUser && ($backendUser->hasAccess('cms.manage_content') || $backendUser->hasAccess('rainlab.pages.manage_content'));
    }

    public function getSetting($setting)
    {

        if (Settings::get($setting)) {
            return Twig::parse(Settings::get($setting));
        } else {
            return '';

        }

    }

}
