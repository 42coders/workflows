<?php

namespace the42coders\Workflows\Fields;

use the42coders\Workflows\DataBuses\DataBusResource;
use the42coders\Workflows\DataBuses\ModelResource;

class TrixInputField implements FieldInterface
{
    public $options;

    public function __construct()
    {
    }

    public static function make()
    {
        return new self();
    }

    public function render($element, $value, $field)
    {
        $placholders = [];

        $placholders['data_bus'] = DataBusResource::getValues($element, $value, $field);
        foreach ($placholders['data_bus'] as $dataBusKey => $dataBusValue) {
            $placholders['data_bus'][$dataBusKey] = '$dataBus->get(\\\''.$dataBusValue.'\\\')';
        }

        $placholders['model'] = ModelResource::getValues($element, $value, $field);
        foreach ($placholders['model'] as $modelKey => $modelValue) {
            $placholders['model'][$modelKey] = '$model->'.$modelValue;
        }

        return view('workflows::fields.trix_input_field', [
            'field' => $field,
            'value' => $value,
            'placeholders' => $placholders,
        ])->render();
    }
}
