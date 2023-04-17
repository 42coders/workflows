<?php

namespace the42coders\Workflows\Tasks;

use Barryvdh\DomPDF\Facade\Pdf;

class DomPDF extends Task
{
    public static $fields = [
        'Html' => 'html',
    ];

    public static $output = [
        'PDFFile' => 'pdf_file',
    ];

    public static $icon = '<i class="fa fa-file-pdf"></i>';

    public function execute(): void
    {
        $pdf = Pdf::loadHTML($this->getData('html'));
        $this->setDataArray('pdf_file', $pdf->output());
    }
}
