<?php


namespace the42coders\Workflows\Conditions;


use the42coders\Workflows\DataBuses\DataBus;
use Illuminate\Database\Eloquent\Model;

interface ConditionInterface
{
    /**
     * Checks if the Condition is fulfilled
     *
     * @return bool
     */
    public function check(Model $model, DataBus $data): bool;

}
