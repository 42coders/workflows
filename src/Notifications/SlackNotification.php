<?php

namespace the42coders\Workflows\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\SlackMessage;

class SlackNotification extends Notification
{
    use Queueable;

    private $message;
    private $to;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($to, $message)
    {
        $this->message = $message;
        $this->to = $to;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['slack'];
    }

    public function toSlack($notifiable)
    {
        return (new SlackMessage)
            ->to($this->to)
            ->content($this->message);
    }
}
