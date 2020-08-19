<?php


namespace the42coders\Workflows\Fields;


class DropdownField implements FieldInterface
{

    public array $options;

    public function __construct(array $options)
    {
        $this->options = $options;
    }

    public static function make(array $options){
        return new self($options);
    }

    public function render($element, $value, $field){
        return view('workflows::fields.dropdown_field', [
            'field' => $field,
            'value' => $value,
            'options' => $this->options,
        ])->render();
    }

}
