<?php namespace Tresfera\Taketsystem\Components;

use Cms\Classes\ComponentBase;
use Tresfera\Taketsystem\Models\Timming;

class Timing extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'Timing Component',
            'description' => 'No description provided yet...'
        ];
    }
    public function onSetTime() {
        $user = \Auth::getUser();
        $timming = new Timming();
        $timming->page = post("page");
        $timming->time = post("time");
        $timming->user_id = $user->id;
        $timming->save();
    }
    public function onRun()
    {
        $this->addJs('/plugins/tresfera/taketsystem/components/timing/assets/js/timeme.min.js');
        $this->addJs('/plugins/tresfera/taketsystem/components/timing/assets/js/load.js');
    }
    public function defineProperties()
    {
        return [];
        
    }
}
