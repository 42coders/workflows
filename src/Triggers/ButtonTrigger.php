<?php

namespace the42coders\Workflows\Triggers;

use Illuminate\Database\Eloquent\Model;
use the42coders\Workflows\Fields\DropdownField;
use the42coders\Workflows\Workflow;

class ButtonTrigger extends Trigger
{
    public static $icon = '<i class="fas fa-mouse"></i>';

    public static $fields = [
        'Name' => 'name',
        'Category' => 'category',
        'Class' => 'class',
        'Caption' => 'caption',
        'CSSClasses' => 'css_classes',
        'CSSStyle' => 'css_style',
    ];

    public function inputFields(): array
    {
        $fields = [
            'class' => DropdownField::make(config('workflows.triggers.Button.classes')),
            'category' => DropdownField::make(config('workflows.triggers.Button.categories')),
        ];

        return $fields;
    }

    /**
     * Renders the button_trigger blade template based on the ButtonTrigger values and the Model passed to the Trigger.
     *
     * @param  Model  $model
     * @return string
     */
    public function renderButton(Model $model): string
    {
        return view('workflows::parts.button_trigger', [
            'caption' => $this->getFieldValue('caption'),
            'css_classes' => $this->getFieldValue('css_classes'),
            'css_style' => $this->getFieldValue('css_style'),
            'model' => $model,
            'triggerId' => $this->id,
        ]);
    }

    /**
     * Renders a TriggerButton based on the Workflow Id. It will only render the first Trigger if two
     * triggers are existing in the Workflow.
     *
     * @param  int  $workflow_id
     * @param  Model  $model
     * @return string
     */
    public static function renderButtonByWorkflowId(int $workflow_id, Model $model): string
    {
        $workflow = Workflow::find($workflow_id);

        if (empty($workflow)) {
            return '';
        }

        $buttonTrigger = $workflow->getTriggerByClass(self::class);

        if (empty($buttonTrigger)) {
            return '';
        }

        return $buttonTrigger->renderButton($model);
    }

    /**
     * Renders a Trigger Button by its defined Name.
     *
     * @param  string  $name
     * @param  Model  $model
     * @return string
     */
    public static function renderButtonByName(string $name, Model $model): string
    {
        $buttonTrigger = self::where('data_fields->name->value', $name)->first();

        if (empty($buttonTrigger)) {
            return '';
        }

        return $buttonTrigger->renderButton($model);
    }

    /**
     * Renders all Trigger Buttons with the same category.
     *
     * @param  string  $categoryName
     * @param  Model  $model
     * @return string
     */
    public static function renderButtonsByCategory(string $categoryName, Model $model): string
    {
        $buttonTriggers = self::where('data_fields->category->value', $categoryName)->get();

        $html = '';

        foreach ($buttonTriggers as $buttonTrigger) {
            $html .= $buttonTrigger->renderButton($model);
        }

        return $html;
    }
}
