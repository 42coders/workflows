<?php


namespace the42coders\Workflows\Tasks;


class Execute extends Task
{

    static array $fields = [
        'Command' => 'command',
    ];

    static array $output = [
        'Command Output' => 'command_output',
    ];

    public static $icon = '<i class="fas fa-terminal"></i>';

    public function execute(): void
    {

        chdir(base_path());

        $this->setData('command_output', shell_exec($this->getData('command')));

    }

}
