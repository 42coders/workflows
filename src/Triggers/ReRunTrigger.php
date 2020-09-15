<?php

namespace the42coders\Workflows\Triggers;

use the42coders\Workflows\Loggers\WorkflowLog;

class ReRunTrigger
{
    public static function startWorkflow(WorkflowLog $log)
    {
        $log->triggerable->start($log->elementable);
    }
}
