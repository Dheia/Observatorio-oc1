<?php namespace Pkurg\PageBuilder;

use Cms\Classes\Theme;
use Config;
use Event;
use Pkurg\PageBuilder\Models\Settings;
use System\Classes\PluginBase;
use System\Classes\SettingsManager;

class Plugin extends PluginBase
{

    public function registerMarkupTags()
    {
        return [
            'filters' => [

                // A local method, i.e $this->makeTextAllCaps()
                'theme' => [$this, 'makeTextAllCaps'],
            ],

        ];
    }

    public function makeTextAllCaps($text)
    {

        $theme = Theme::getActiveTheme();
        return url('/') . config('cms.themesPath') . '/'
        . $theme->getDirName() . '/' . $text;
    }

    public function registerComponents()
    {
        return [
            'Pkurg\PageBuilder\Components\ContentBuilder' => 'ContentBuilder',
        ];
    }

    public function registerPermissions()
    {
        return [
            'pkurg.pagebuilder.manage' => [
                'tab' => 'Page Builder',
                'label' => 'Manage Custom fields',
            ],

        ];
    }

    public function registerSettings()
    {

        return [
            'settings' => [
                'label' => 'Page Builder',
                'description' => 'Manage Page Builder settings.',
                'category' => SettingsManager::CATEGORY_CMS,
                'icon' => 'oc-icon-building-o',
                'class' => 'Pkurg\PageBuilder\Models\Settings',
                'order' => 500,
                'permissions' => ['pkurg.pagebuilder.manage'],

            ],
        ];

    }

    public function registerFormWidgets()
    {
        return [
            'Pkurg\PageBuilder\FormWidgets\Editor' => 'pagebuilder',

        ];
    }

    public function boot()
    {

        Event::listen('backend.form.extendFields', function ($form) {

            if (get_class($form->config->model) == 'Cms\Classes\Page' and Settings::get('show_page')) {

                replaceEditor($form);

            }

            if (get_class($form->config->model) == 'Cms\Classes\Content' and Settings::get('show_content')) {

                replaceEditor($form);
            }
            if (get_class($form->config->model) == 'Cms\Classes\Partial' and Settings::get('show_partial')) {

                replaceEditor($form);
            }
            if (get_class($form->config->model) == 'Cms\Classes\Layout' and Settings::get('show_layout')) {

                replaceEditor($form);
            }

        });

        function replaceEditor($form)
        {
            $replacable = [
                'codeeditor', 'Eein\Wysiwyg\FormWidgets\Trumbowyg', 'richeditor', 'RainLab\Blog\FormWidgets\BlogMarkdown',
                'RainLab\Blog\FormWidgets\MLBlogMarkdown', 'mlricheditor',
            ];

            $multilanguage = [
                'RainLab\Blog\FormWidgets\MLBlogMarkdown', 'mlricheditor',
            ];

            foreach ($form->getFields() as $field) {

                if (!empty($field->config['type']) && $field->config['type'] == 'codeeditor' && $field->fieldName == 'markup') {

                    $field->config['type'] = $field->config['widget'] = 'pagebuilder';

                }

            }
        }

    }

}
