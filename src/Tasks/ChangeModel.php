<?php

namespace the42coders\Workflows\Tasks;

use the42coders\Workflows\Fields\DropdownField;

class ChangeModel extends Task
{
    public static $fields = [
        'Model' => 'model',
        'Field' => 'field',
        'Value' => 'value',
    ];

    public static $output = [
        'Output' => 'output',
    ];

    public static $icon = '<i class="fas fa-database"></i>';

    public function execute(): void
    {
        $model = $this->getData('model');
        $field = $this->getData('field');
        $value = $this->getData('value');

        $model->$field = $value;

        $this->setData('output', $model);
    }
}
