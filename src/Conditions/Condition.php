<?php


namespace the42coders\Workflows\Conditions;

use the42coders\Workflows\DataBuses\DataBus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use the42coders\Workflows\DataBuses\DataBussable;
use the42coders\Workflows\Fields\Fieldable;


class Condition extends Model implements ConditionInterface
{

    use DataBussable, Fieldable;

    public $condition;

    public function actions()
    {
        return $this->belongsToMany('the42coders\Workflows\Tasks\Task', 'action_condition', 'action_id', 'condition_id');
    }

    public function actionContainers()
    {
        return $this->belongsToMany('the42coders\Workflows\Workflow');
    }

    /**
     * Return Collection of models by type.
     *
     * @param array $attributes
     * @param null $connection
     *
     * @return \App\Models\Action
     */
    public function newFromBuilder($attributes = [], $connection = null)
    {
        $entryClassName = Arr::get((array)$attributes, 'type');
        if (0 !== strpos($entryClassName, '\\')) {
            $entryClassName = __NAMESPACE__ . '\\' . $entryClassName;
        }

        $definedClasses = config('42p_actions.condition_types');

        if (array_key_exists($entryClassName, $definedClasses)) {
            $entryClassName = $definedClasses[$entryClassName];
        }

        if (class_exists($entryClassName)
            && is_subclass_of($entryClassName, self::class)
        ) {
            $model = new $entryClassName();
        } else {
            $model = $this->newInstance();
        }

        $model->exists = true;
        $model->setRawAttributes((array)$attributes, true);
        $model->setConnection($connection ?: $this->connection);

        return $model;
    }

    public function check(Model $model, DataBus $dataBus): bool
    {
        return true;
    }

    public function compareValues($value1, $operator, $value2)
    {
        switch ($operator) {
            case '==':
                return $value1 == $value2;
            case '===':
                return $value1 === $value2;
            case '!=':
                return $value1 != $value2;
            case '!==':
                return $value1 !== $value2;
            case '<':
                return $value1 < $value2;
            case '<=':
                return $value1 <= $value2;
            case '>':
                return $value1 > $value2;
            case '>=':
                return $value1 >= $value2;
            case '>=':
                return $value1 >= $value2;
        }

        return false;
    }


}
