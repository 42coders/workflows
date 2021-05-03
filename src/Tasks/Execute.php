<?php

namespace The42Coders\Workflows\Tasks;

class Execute extends Task
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
        chdir(base_path());

        $this->setData('command_output', shell_exec($this->getData('command')));
    }
}
