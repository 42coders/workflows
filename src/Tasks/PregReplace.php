<?php

namespace The42Coders\Workflows\Tasks;

class PregReplace extends Task
{
    public static $fields = [
        'Patter' => 'pattern',
        'Replacement' => 'replacement',
        'Subject' => 'subject',
    ];

    public static $output = [
        'Preg Replace Output' => 'preg_replace_output',
    ];

    public static $icon = '<i class="fas fa-shipping-fast"></i>';

    public function execute(): void
    {
        $this->setData('preg_replace_output', preg_replace(
            $this->getData('pattern'),
            $this->getData('replacement'),
            $this->getData('subject')));
    }
}
