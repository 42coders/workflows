<?php


namespace the42coders\Workflows\Triggers;


use the42coders\Workflows\Fields\DropdownField;

class ObserverTrigger extends Trigger
{

    public static $icon = '<i class="fas fa-binoculars"></i>';

    public static array $fields = [
        'Class' => 'class',
        'Event' => 'event',
    ];

    public function inputFields(): array
    {
        $fields = [
            'class' => DropdownField::make(config('workflows.triggers.Observers.classes')),
            'event' => DropdownField::make(array_combine(config('workflows.triggers.Observers.events'), config('workflows.triggers.Observers.events'))),
        ];

        return $fields;
    }
}
