<?php


namespace the42coders\Workflows\DataBuses;


use Illuminate\Database\Eloquent\Model;
use the42coders\Workflows\Workflow;
use Illuminate\Support\Facades\Schema;

class ModelResource implements Resource
{

    public function getData(string $name, string $value, Model $model, DataBus $dataBus)
    {
        return $model->{$value};
    }

    public static function getValues(Model $element, $value, $field_name){
        $classes = [];
        foreach($element->workflow->triggers as $trigger){
            if(isset($trigger->data_fields['class']['value'])) {
                $classes[] = $trigger->data_fields['class']['value'];
            }
        }

        $variables = [];
        foreach($classes as $class){
            $model = new $class;
            foreach(Schema::getColumnListing($model->getTable()) as $item){
                $variables[$class.'->'.$item] = $item;
            }
        }

        return $variables;
    }

    public static function checkCondition(Model $element, String $field, String $operator, String $value)
    {
        switch($operator){
            case 'equal':
                return $element->{$field} == $value;
            case 'not_equal':
                return $element->{$field} != $value;
            default:
                return true;
        }
    }

    public static function loadResourceIntelligence(Model $element, $value, $field_name)
    {

        $variables = self::getValues($element, $value, $field_name);

        return view('workflows::fields.data_bus_resource_field', [
            'fields' => $variables,
            'value' => $value,
            'field' => $field_name,
        ])->render();
    }

}
