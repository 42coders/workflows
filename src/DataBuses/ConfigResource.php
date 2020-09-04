<?php


namespace the42coders\Workflows\DataBuses;


use Illuminate\Database\Eloquent\Model;

class ConfigResource implements Resource
{
    public function getData(string $name, string $value, Model $model, DataBus $dataBus)
    {

        return config($value);

    }

    public static function getValues(Model $element, $value, $field)
    {
        return [];
    }

    public static function loadResourceIntelligence(Model $element, $value, $field)
    {
        if($element->inputField($field)){
            return $element->inputField($field)->render($field, $value);
        }

        return view('workflows::fields.text_field', [
            'value' => $value,
            'field' => $field,
        ])->render();
    }
}
