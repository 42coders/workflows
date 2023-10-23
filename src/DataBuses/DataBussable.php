<?php

namespace the42coders\Workflows\DataBuses;

trait DataBussable
{
    public function workflow()
    {
        return $this->belongsTo('the42coders\Workflows\Workflow');
    }

    public function getParentDataBusKeys($passedFields = [])
    {
        $newFields = $passedFields;

        if (! empty($this->parentable)) {
            //foreach($this->parentable::$fields as $key => $value){
            //    $newFields[$key] = $this->parentable->name.' - '.$value;
            //}
            foreach ($this->parentable::$output as $key => $value) {
                $newFields[$this->parentable->name.' - '.$key.' - '.$this->parentable->getFieldValue($value)] = $this->parentable->getFieldValue($value);
            }

            $newFields = $this->parentable->getParentDataBusKeys($newFields);
        }

        return $newFields;
    }

    public function getData(string $value, string $default = '')
    {
        return $this->dataBus->get($value, $default);
    }

    public function setDataArray(string $key, $value)
    {
        return $this->dataBus->setOutputArray($key, $value);
    }

    public function setData(string $key, $value)
    {
        return $this->dataBus->setOutput($key, $value);
    }
}
