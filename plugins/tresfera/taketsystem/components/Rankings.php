<?php namespace Tresfera\Taketsystem\Components;

use Cms\Classes\ComponentBase;
use RainLab\User\Models\User;
class Rankings extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'rankings Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function teams() {
        $ranking = User::leftjoin("tresfera_taketsystem_progresos_answers","users.id","=","tresfera_taketsystem_progresos_answers.user_id")
                        ->addSelect(\DB::raw("SUM( points*peso/100 )/count(DISTINCT users.id) as points"))
                        ->addSelect(\DB::raw("company as team"))
                        ->where("company","<>","")
                        ->groupBy("company")
                        ->orderBy("points","DESC");
        if(get('comp')) {
            $ranking->where("quiz",get('comp'));
        }        
        return $ranking->get();
    }
}
