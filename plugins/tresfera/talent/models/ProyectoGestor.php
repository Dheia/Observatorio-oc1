<?php namespace Tresfera\Talent\Models;

use Model;
use Backend\Models\User;

/**
 * Model
 */
class ProyectoGestor extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'tresfera_talent_proyectos_gestores';
    public $belongsTo = [
        'gestor' => 'Tresfera\Talent\Models\Gestor',
        'proyecto' => 'Tresfera\Talent\Models\Proyecto'
    ];
    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public function beforeCreate() {
        $user = User::find($this->gestor->user_id);
        $count = \DB::table('backend_user_preferences')->where("user_id",$user->id)->count();
        if($count) return;
        if($this->proyecto->lang == "es") {
            \DB::table('backend_user_preferences')->insert(
                [
                 'user_id' => $user->id,
                 'namespace' => 'backend',
                 'group' => 'backend',
                 'item' => 'preferences',
                 'value' => '{"locale":"es","fallback_locale":"es","timezone":"UTC","editor_font_size":"12","editor_word_wrap":"fluid","editor_code_folding":"manual","editor_tab_size":"4","editor_theme":"twilight","editor_show_invisibles":false,"editor_highlight_active_line":true,"editor_use_hard_tabs":false,"editor_show_gutter":true,"editor_auto_closing":false,"editor_autocompletion":"manual","editor_enable_snippets":false,"editor_display_indent_guides":false,"editor_show_print_margin":false,"user_id":"'.$user->id.'"}'               
                ]
            );
          }
          if($this->proyecto->lang == "en") {
            \DB::table('backend_user_preferences')->insert(
                [
                 'user_id' => $user->id,
                 'namespace' => 'backend',
                 'group' => 'backend',
                 'item' => 'preferences',
                 'value' => '{"locale":"en","fallback_locale":"en","timezone":"UTC","editor_font_size":"12","editor_word_wrap":"fluid","editor_code_folding":"manual","editor_tab_size":"4","editor_theme":"twilight","editor_show_invisibles":false,"editor_highlight_active_line":true,"editor_use_hard_tabs":false,"editor_show_gutter":true,"editor_auto_closing":false,"editor_autocompletion":"manual","editor_enable_snippets":false,"editor_display_indent_guides":false,"editor_show_print_margin":false,"user_id":"'.$user->id.'"}'               
                ]
            );
        }
    }
}
