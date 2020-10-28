<?php

namespace the42coders\Workflows\Triggers;

use Illuminate\Database\Eloquent\Model;
use the42coders\Workflows\Fields\DropdownField;

class ButtonTrigger extends Trigger
{
    public static $icon = '<i class="fas fa-mouse"></i>';

    public static $fields = [
        'Class' => 'class',
        'Caption' => 'caption',
        'ButtonType' => 'buttonType',
        'RenderPosition' => 'renderPosition',
    ];

    public function inputFields(): array
    {
        $fields = [
            'class' => DropdownField::make(config('workflows.triggers.Button.classes')),

        ];

        return $fields;
    }

    public function renderButton(Model $model)
    {
        return view('workflows::parts.button_trigger', [
            'caption' => $this->getFieldValue('caption'),
            'buttonType' => $this->getFieldValue('buttonType'),
            'model' => $model,
            'triggerId' => $this->id,
        ]);
    }
}
