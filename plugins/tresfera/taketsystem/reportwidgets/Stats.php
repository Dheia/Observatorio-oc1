<?php
namespace Tresfera\Taketsystem\ReportWidgets;

use Backend\Classes\ReportWidgetBase;

class Stats extends ReportWidgetBase
{
    public function render()
    {	
        return $this->makePartial('welcome',["user"=>$this->controller->user]);
    }
    /**
     * {@inheritDoc}
     */
    public function loadAssets()
    {
        $this->addCss('css/templateselector.css', 'Tresfera.Taketsystem');
        $this->addJs('js/templateselector.js',    'Tresfera.Taketsystem');
    }
}

?>