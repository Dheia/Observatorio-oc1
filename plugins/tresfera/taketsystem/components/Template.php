<?php

namespace Tresfera\Taketsystem\Components;

use Cms\Classes\ComponentBase;

class Template extends ComponentBase
{
    var $data = [];
    public function componentDetails()
    {
        return [
            'name'        => 'Slide Template',
            'description' => 'Used for displaying web-based versions of slides.',
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function init() {
      $this->data = ["a"];
    }
}
