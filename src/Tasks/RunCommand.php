<?php

namespace the42coders\Workflows\Tasks;

use Illuminate\Support\Facades\Artisan;

class RunCommand extends Task
{
    public static $fields = [
        'Command' => 'command',
    ];

    public static $output = [
        'Command Output' => 'command_output',
    ];

    public static $icon = '<i class="fas fa-terminal"></i>';

    public function execute(): void
    {
        $this->setData('command_output', Artisan::call($this->getData('command')));
    }
}
