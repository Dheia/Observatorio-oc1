<?php

namespace DamianLewis\SortableRelations\Behaviors;

use October\Rain\Exception\ApplicationException;
use Backend\Classes\ControllerBehavior;

class SortableRelationsOne extends ControllerBehavior
{
    /**
     * @inheritDoc
     */
    protected $requiredProperties = ['sortableRelationConfig'];

    /**
     * @var array Configuration values that must exist when applying the primary config file.
     * - modelClass: Class name for the parent models
     * - relationName: Name of the sortable relation
     */
    protected $requiredConfig = ['modelClass', 'relationName'];

    /**
     * The parent model class name.
     *
     * @var string
     */
    public $modelClass;

    /**
     * The relation name.
     *
     * @var string
     */
    public $relationName;

    /**
     * SortableRelations constructor.
     *
     * @param $controller
     *
     * @throws \ApplicationException
     * @throws \SystemException
     */
    public function __construct($controller)
    {
        parent::__construct($controller);

        $this->assetPath = '/plugins/damianlewis/sortablerelations/assets';

        /*
         * Build configuration
         */
        $this->config = $this->makeConfig($controller->sortableRelationConfig, $this->requiredConfig);

        $this->initRelationList();
    }

    /**
     * Disable sorting and order the view.list by the pivot sort order.
     *
     * @param object $config
     *
     * @return void
     */
    public function relationExtendConfig($config)
    {
        $config->view['showSorting'] = false;
        $config->view['defaultSort'] = [
            'column'    => 'relation_sort_order',
            'direction' => 'asc'
        ];
    }

    /**
     * Ajax event handler to update the relation sort order with a new position.
     *
     * @return void
     * @throws \October\Rain\Exception\ApplicationException
     */
    public function update_onRelationReorder()
    {
        $model = $this->getParentModelClass();
        $relationName = $this->getRelationName();
        $parentId = $this->getParentId();
        $relatedId = $this->getRelatedId();

        $object = call_user_func_array("{$model}::find", [$parentId]);

        $relationObject = $object->$relationName()->find($relatedId);
       // echo $relationObject->relation_sort_order."\n";
        if(post('position')>$relationObject->relation_sort_order) { //si la posicion de destino es mas grande que la actual
            for($i=$relationObject->relation_sort_order+1; $i<=post('position'); $i++) {
                $relationObjectDest = $object->$relationName()->where("relation_sort_order",$i)->whereNull("deleted_at")->first();
                if(isset($relationObjectDest->id)) {
                    //echo $relationObjectDest->relation_sort_order. " --> ";
                    $relationObjectDest->relation_sort_order -= 1;
                   // echo $relationObjectDest->relation_sort_order. "\n";

                    $relationObjectDest->save();
                }
            }
        } else {
            for($i=$relationObject->relation_sort_order-1; $i>=post('position'); $i--) {
                $relationObjectDest = $object->$relationName()->where("relation_sort_order",$i)->whereNull("deleted_at")->first();
                if(isset($relationObjectDest->id)) {
                   // echo $relationObjectDest->relation_sort_order. " --> ";
                    $relationObjectDest->relation_sort_order += 1;
                   // echo $relationObjectDest->relation_sort_order. "\n";
                    $relationObjectDest->save();
                }
            }
        }

        

        $relationObject->relation_sort_order = post('position');
        $relationObject->save();
    }

    /**
     * Add the page assets need for sorting.
     *
     * @return void
     */
    protected function initRelationList()
    {
        $this->addJs('js/Sortable.js'); // Sortable.min.js has a bug: https://stackoverflow.com/questions/48804134/rubaxa-sortable-failed-to-execute-matches-on-element-is-not-a-valid-se
        $this->addJs('js/list-widget-sortable.js');
        $this->addCss('css/list-widget-sortable.css');
    }

    /**
     * Get the name of the parent model class from the config file.
     *
     * @return string
     * @throws \October\Rain\Exception\ApplicationException
     */
    protected function getParentModelClass()
    {
        if ($this->modelClass !== null) {
            return $this->modelClass;
        }

        $modelClass = $this->getConfig('modelClass');

        if (!$modelClass) {
            throw new ApplicationException('Please specify the modelClass property for the parent model');
        }

        return $this->modelClass = $modelClass;
    }

    /**
     * Get the name of the relation from the config file.
     *
     * @return string
     * @throws \October\Rain\Exception\ApplicationException
     */
    protected function getRelationName()
    {
        if ($this->relationName !== null) {
            return $this->relationName;
        }

        $relationName = $this->getConfig('relationName');

        if (!$relationName) {
            throw new ApplicationException('Please specify the relationName property');
        }

        return $this->relationName = $relationName;
    }

    /**
     * Get the posted id for the related model.
     *
     * @return int
     * @throws \October\Rain\Exception\ApplicationException
     */
    protected function getRelatedId()
    {
        if ($relatedId = post('relatedId')) {
            return (int)$relatedId;
        }

        throw new ApplicationException('Please specify the ID for the related model.');
    }

    /**
     * Get the posted id for the parent model.
     *
     * @return int
     * @throws \October\Rain\Exception\ApplicationException
     */
    protected function getParentId()
    {
        if ($parentId = post('parentId')) {
            return (int)$parentId;
        }

        throw new ApplicationException('Please specify the ID for the parent model.');
    }
}