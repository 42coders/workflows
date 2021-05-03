<?php

namespace The42Coders\Workflows;

use Illuminate\Support\Facades\Facade;

/**
 * @see The42Coders\Workflows\Skeleton\SkeletonClass
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
