<?php

namespace the42coders\Workflows;

use Illuminate\Support\Facades\Facade;

/**
 * @see the42coders\Workflows\Skeleton\SkeletonClass
 */
class WorkflowsFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'workflows';
    }
}
