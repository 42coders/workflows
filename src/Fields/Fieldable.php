<?php


namespace the42coders\Workflows\Fields;

/**
 * Trait Fieldable
 *
 * Access the Data Fields of an Element.
 *
 * @package the42coders\Workflows\Fields
 */
trait Fieldable
{

    /**
     * Return the Field value. If Field is not existing it returns the Field name.
     *
     * @param string $field
     * @return string
     */
    public function getFieldValue(string $field): string
    {

        if(empty($field)){
            return '';
        }

        if(!isset($this->data_fields[$field])){
            return '';
        }

        if(empty($this->data_fields[$field]['value'])){
            return '';
        }

        return $this->data_fields[$field]['value'];

    }

    /**
     * Returns the Field Type. If Field is not existing it returns an empty String.
     *
     * @param string $field
     * @return string
     */
    public function getFieldType(string $field): string
    {

        return isset($this->data_fields[$field]) ? $this->data_fields[$field]['type'] : '';

    }

    /**
     * Check if the Field is from the passed resourceType.
     *
     * @param string $field
     * @param string $resourceType
     * @return bool
     */
    public function fieldIsResourceType(string $field, string $resourceType): bool
    {

        return $this->getFieldType($field) === $resourceType;

    }

    /**
     * Pass selected back if the resourceType is selected for this field. If not an empty String.
     *
     * @param string $field
     * @param string $resourceType
     * @return string
     */
    public function fieldIsSelected(string $field, string $resourceType): string
    {

        return $this->fieldIsResourceType($field, $resourceType) ? 'selected' : '';

    }


    /**
     * Loads Resource Intelligence from the corresponding DataResourceClass.
     * If non is set its taking the first defined one from Config.
     *
     * @param string $field
     * @return string
     */
    public function loadResourceIntelligence(string $field): string
    {

        if(!isset($this->data_fields[$field])){
            $resources = config('workflows.data_resources');
            $class = reset($resources);
        }else{
            $className = $this->getFieldType($field);
            $class = new $className();
        }

        return $class::loadResourceIntelligence($this, $this->getFieldValue($field), $field);
    }

    public function inputFields(): array
    {
        return [];
    }

}
