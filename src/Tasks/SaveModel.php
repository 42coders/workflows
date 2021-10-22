<?php

namespace the42coders\Workflows\Tasks;

class SaveModel extends Task
{
    public static $fields = [
        'Model' => 'model',
    ];

    public static $output = [
        'Output' => 'output',
    ];

    public static $icon = '<i class="fas fa-database"></i>';

    public function execute(): void
    {
        $model = $this->getData('model');

        $model->save();

        $this->setData('output', $model);
    }
}
