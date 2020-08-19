<?php


namespace the42coders\Workflows\Tasks;


use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use the42coders\Workflows\Fields\TrixInputField;
use Barryvdh\DomPDF\Facade as PDF;

class SaveFile extends Task
{

    static array $fields = [
        'File' => 'file',
        'FileName' => 'file_name'
    ];

    public static $icon = '<i class="fa fa-file-pdf"></i>';


    public function execute(): void
    {

        Storage::put($this->getData('file'), $this->getData('file_name'));

    }

}
