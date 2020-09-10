<?php


namespace the42coders\Workflows\DataBuses;


use Illuminate\Database\Eloquent\Model;

class ValueResource implements Resource
{
    public function getData(string $name, string $value, Model $model, DataBus $dataBus)
    {
        return $value;
    }

    public static function getValues(Model $element, $value, $field)
    {
        return [];
    }

    public static function checkCondition(Model $element, DataBus $dataBus, String $field, String $operator, String $value)
    {
        switch($operator){
            case 'equal':
                return $dataBus->get($field) == $value;
            case 'not_equal':
                return $dataBus->get($field) != $value;
            default:
                return true;
        }
    }

    public static function loadResourceIntelligence(Model $element, $value, $field)
    {

        if($element->inputField($field)){
            return $element->inputField($field)->render($element, $value, $field);
        }

        return view('workflows::fields.text_field', [
            'value' => $value,
            'field' => $field,
        ])->render();
    }
}
