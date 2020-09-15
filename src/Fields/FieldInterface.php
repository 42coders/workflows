<?php

namespace the42coders\Workflows\Fields;

interface FieldInterface
{
    public function render($element, $value, $field);
}
