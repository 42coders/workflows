<?php


namespace the42coders\Workflows\DataBuses;


use Illuminate\Database\Eloquent\Model;

class DataBusResource implements Resource
{
    public function getData(string $name, string $value, Model $model, DataBus $dataBus)
    {

        return $dataBus->data[$dataBus->data[$value]];

    }

    public static function getValues(Model $element, $value, $field)
    {
        return $element->getParentDataBusKeys();
    }

    public static function loadResourceIntelligence(Model $element, $value, $field)
    {
        $fields = self::getValues($element, $value, $field);

        return view('workflows::fields.data_bus_resource_field', [
            'fields' => $fields,
            'value' => $value,
            'field' => $field,
        ])->render();
    }
}
