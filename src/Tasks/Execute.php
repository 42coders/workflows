<?php


namespace the42coders\Workflows\Tasks;


class Execute extends Task
{

    static $fields = [
        'Command' => 'command',
    ];

    static $output = [
        'Command Output' => 'command_output',
    ];

    public static $icon = '<i class="fas fa-terminal"></i>';

    public function execute(): void
    {

        chdir(base_path());

        $this->setData('command_output', shell_exec($this->getData('command')));

    }

}
