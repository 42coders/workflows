<?php

namespace The42Coders\Workflows\Tasks;

use Illuminate\Database\Eloquent\Model;
use The42Coders\Workflows\DataBuses\DataBus;

interface TaskInterface
{
    /**
     * Execute the Action return Value tells you about the success.
     *
     * @param Model $model
     * @param Collection $data
     * @return Collection
     */
    public function execute(): void;

    /**
     * Checks if all Conditions pass for this Action.
     *
     * @param Model $model
     * @param DataBus $data
     * @return bool
     */
    public function checkConditions(Model $model, DataBus $data): bool;
}
