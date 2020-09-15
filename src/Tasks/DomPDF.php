<?php


namespace the42coders\Workflows\Tasks;


use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use the42coders\Workflows\Fields\TrixInputField;
use Barryvdh\DomPDF\Facade as PDF;

class DomPDF extends Task
{

    static $fields = [
        'Html' => 'html',
    ];

    static $output = [
        'PDFFile' => 'pdf_file',
    ];

    public static $icon = '<i class="fa fa-file-pdf"></i>';


    public function execute(): void
    {
        $pdf = PDF::loadHTML($this->getData('html'));
        $this->setDataArray('pdf_file', $pdf->output());
    }

}
