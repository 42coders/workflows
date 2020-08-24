<?php


namespace the42coders\Workflows\Tasks;


use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

class SendMail extends Task
{
    public static array $fields = [
        'Subject' => 'subject',
        'Recipients' => 'recipients',
        'Sender' => 'sender',
        'Content' => 'content',
    ];

    public static $icon = '<i class="far fa-envelope"></i>';

    public function execute(): void
    {

        $dataBus = $this->dataBus;

        \Mail::html($dataBus->get('content'), function ($message) use ($dataBus) {
            $message->subject($dataBus->get('subject'))
                ->to($dataBus->get('recipients'))
                ->from($dataBus->get('sender'));
               // ->attachData($dataBus->get('pdf_file'), 'Datei');
        });

    }

}
