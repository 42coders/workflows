<?php


namespace the42coders\Workflows\Tasks;


use the42coders\Workflows\DataBuses\DataBus;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class HttpStatus extends Task
{

    static array $fields = [
        'Url' => 'url',
    ];

    static array $output = [
        'HTTP Status' => 'http_status',
    ];

    public static $icon = '<i class="far fa-eye"></i>';

    public function execute(): void
    {

        $this->setData('http_status', Http::get($this->getData('url'))->status());

    }

}
