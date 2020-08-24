<?php


namespace the42coders\Workflows\Conditions;

use the42coders\Workflows\DataBuses\DataBus;
use Illuminate\Database\Eloquent\Model;

class ModelValueIs extends Condition
{
    public function check(Model $model, DataBus $data): bool
    {

        return $this->compareValues();
    }
}
