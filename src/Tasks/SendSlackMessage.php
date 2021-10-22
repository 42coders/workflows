<?php

namespace the42coders\Workflows\Tasks;

use the42coders\Workflows\Fields\DropdownField;
use the42coders\Workflows\Notifications\SlackNotification;
use Illuminate\Support\Facades\Notification;

class SendSlackMessage extends Task
{
    public static $fields = [
        'Channel/User' => 'channel',
        'Message' => 'message',
    ];

    public static $output = [
        'Output' => 'output',
    ];

    public static $icon = '<i class="fab fa-slack"></i>';

    public function execute(): void
    {
        $channel = $this->getData('channel');
        $message = $this->getData('message');

        Notification::route('slack', env('WORKFLOW_SLACK_CHANNEL'))
            ->notify(new SlackNotification($channel, $message));
    }
}
