<?php


namespace the42coders\Workflows\DataBuses;


use Illuminate\Database\Eloquent\Model;

interface Resource
{
    public function getData(string $name, string $value, Model $model, DataBus $dataBus);

    public static function loadResourceIntelligence(Model $element, $value, $field_name);
}
