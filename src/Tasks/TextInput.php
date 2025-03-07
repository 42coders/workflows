<?php

namespace the42coders\Workflows\Tasks;

use Illuminate\Support\Facades\Blade;
use the42coders\Workflows\Fields\TextInputField;

class TextInput extends Task
{
    public static $fields = [
        'Text' => 'text',
    ];

    public static $output = [
        'TextOutput' => 'text_output',
    ];

    public static $icon = '<i class="fas fa-font"></i>';

    public function inputFields(): array
    {
        return [
            'text' => TextInputField::make(),
        ];
    }

    public function execute(): void
    {
        $text = str_replace('&gt;', '>', $this->getData('text'));

        $php = Blade::compileString($text);
        $text = $this->render($php, [
            'model' => $this->model,
            'dataBus' => $this->dataBus,
        ]);

        $this->setData('text_output', $text);
    }

    public function render($__php, $__data)
    {
        $obLevel = ob_get_level();
        ob_start();
        extract($__data, EXTR_SKIP);
        try {
            eval('?'.'>'.$__php);
        } catch (Exception $e) {
            while (ob_get_level() > $obLevel) {
                ob_end_clean();
            }
            throw $e;
        } catch (Throwable $e) {
            while (ob_get_level() > $obLevel) {
                ob_end_clean();
            }
            throw new FatalThrowableError($e);
        }

        return ob_get_clean();
    }
}
