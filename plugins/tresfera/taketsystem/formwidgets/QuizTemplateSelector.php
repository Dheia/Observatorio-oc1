<?php

namespace Tresfera\Taketsystem\FormWidgets;

use Backend\Classes\FormWidgetBase;
use Tresfera\Taketsystem\Models\Quiz;
use BackendAuth;

/**
 * Quiz Template Selector Form Widget.
 */
class QuizTemplateSelector extends FormWidgetBase
{
    /**
     * {@inheritDoc}
     */
    protected $defaultAlias = 'quiztempalteselector';

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
            'name'        => 'Quiz Template selector',
            'description' => 'Select a quiz template to use',
        ];
    }

    /**
     * Prepares the form widget view data.
     */
    public function prepareVars()
    {
        $user = BackendAuth::getUser();
        $clientId = isset($user->client->id) ? $user->client->id : null;
        $query = Quiz::isTemplate($clientId);
        if ($type = post('Quiz[type]')) {
            $query->whereType($type);
        }
        $this->vars['name'] = $this->formField->getName();
        $this->vars['value'] = $this->getLoadValue();
        $this->vars['model'] = $this->model;
        $this->vars['quizzes'] = $query->get();
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
        $this->addJs('js/templateselector.js',    'Tresfera.Taketsystem');
    }

    /**
     * {@inheritDoc}
     */
    public function getSaveValue($value)
    {
        return $value;
    }
}
