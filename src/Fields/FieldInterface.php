<?php

namespace The42Coders\Workflows\Fields;

interface FieldInterface
{
    public function render($element, $value, $field);
}
