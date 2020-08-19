<?php


namespace the42coders\Workflows\Triggers;

use the42coders\Workflows\Loggers\WorkflowLog;
use the42coders\Workflows\Workflow;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ReRunTrigger
{

    public static function startWorkflow(WorkflowLog $log)
    {

        $log->triggerable->start($log->elementable);

    }

}
