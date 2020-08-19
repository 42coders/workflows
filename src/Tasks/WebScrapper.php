<?php


namespace the42coders\Workflows\Tasks;


use the42coders\Workflows\DataBuses\DataBus;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

class WebScrapper extends Task
{

    static array $fields = [
        'Patter' => 'pattern',
        'Replacement' => 'replacement',
        'Subject' => 'subject',
    ];

    static array $output = [
        'Preg Replace Output' => 'preg_replace_output',
    ];

    public static $icon = '<i class="fas fa-shipping-fast"></i>';

    public function execute(): void
    {

        $this->setData('preg_replace_output', Http::get($this->getData('url'))->status());

    }

}
