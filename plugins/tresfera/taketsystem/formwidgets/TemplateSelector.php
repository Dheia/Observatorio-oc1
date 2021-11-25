<?php

namespace Tresfera\Taketsystem\FormWidgets;

use Tresfera\Taketsystem\Models\SlideType;
use Backend\Classes\FormWidgetBase;
use Input;

/**
 * TemplateSelector Form Widget.
 */
class TemplateSelector extends FormWidgetBase
{
    /**
     * {@inheritDoc}
     */
    protected $defaultAlias = 'templateselector';

    /**
     * {@inheritDoc}
     */
    public function init()
    {
    }

    /**
     * Details.
     *
     * @return array
     */
    public function widgetDetails()
    {
        return [
            'name'        => 'Template selector',
            'description' => 'Select a slide template to use',
        ];
    }

    /**
     * Prepares the form widget view data.
     */
    public function prepareVars()
    {
        $this->vars['name'] = $this->formField->getName();
        $this->vars['value'] = $this->getLoadValue();
        $this->vars['model'] = $this->model;
        $type = Input::get($this->formField->arrayName.'.type');
        $this->vars['pages'] = $this->model->listPagesWithCampaignComponent($type);
    }

    /**
     * {@inheritDoc}
     */
    public function render()
    {
        $this->prepareVars();

        return $this->makePartial('templateselector');
    }

    /**
     * {@inheritDoc}
     */
    public function loadAssets()
    {
        $this->addCss('css/templateselector.css', 'Tresfera.Taketsystem');
        $this->addJs('js/templateselector.js', 'Tresfera.Taketsystem');
    }

    /**
     * {@inheritDoc}
     */
    public function getSaveValue($value)
    {
        return $value;
    }
}
