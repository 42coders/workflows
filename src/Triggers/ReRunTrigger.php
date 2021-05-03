<?php

namespace The42Coders\Workflows\Triggers;

use The42Coders\Workflows\Loggers\WorkflowLog;

class ReRunTrigger
{
    public static function startWorkflow(WorkflowLog $log)
    {
        $log->triggerable->start($log->elementable);
    }
}
