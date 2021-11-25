<?php namespace Pkurg\PageBuilder\FormWidgets;

use Backend\Classes\FormWidgetBase;
use Pkurg\PageBuilder\Models\Settings;
use Twig;

class Editor extends FormWidgetBase
{

    /**
     * @var string A unique alias to identify this widget.
     */
    protected $defaultAlias = 'pagebuilder';

    public function render()
    {

        //$this->vars['id'] = $this->getId();
        //$this->vars['editorname'] = uniqid();

        $this->vars['name'] = $this->getFieldName();
        $this->vars['value'] = $this->getLoadValue();

        if (Settings::get('builder_styles')) {
            $this->vars['builder_styles'] = Twig::parse(Settings::get('builder_styles'));
        } else {
            $this->vars['builder_styles'] = '';
        }

        if (Settings::get('builder_scripts')) {
            $this->vars['builder_scripts'] = Twig::parse(Settings::get('builder_scripts'));
        } else {
            $this->vars['builder_scripts'] = '';
        }

        $this->vars['curdir'] = url('/');

        $this->vars['customblocks'] = Settings::get('customblocks');

        return $this->makePartial('builder');
    }

}
