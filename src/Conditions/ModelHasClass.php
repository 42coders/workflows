<?php


namespace the42coders\Workflows\Conditions;

use the42coders\Workflows\DataBuses\DataBus;
use Illuminate\Database\Eloquent\Model;

class ModelHasClass extends Condition
{
    public function check(Model $model, DataBus $data): bool
    {

        if(get_class($model) == 'test'){
            return true;
        }

        return false;
    }
}
