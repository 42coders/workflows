<?php


namespace the42coders\Workflows\Tests;

use Illuminate\Support\Carbon;
use the42coders\Workflows\DataBuses\DataBus;
use the42coders\Workflows\Loggers\TaskLog;
use the42coders\Workflows\Loggers\WorkflowLog;
use the42coders\Workflows\Triggers\Trigger;
use the42coders\Workflows\Workflow;
use the42coders\Workflows\Workflows;
use the42coders\Workflows\WorkflowsServiceProvider;

class WorkflowLogTest extends TestCase
{

    private function getWorkflowLog()
    {
        $workflow = new Workflow();
        $workflow->id = 1;
        $workflow->name = 'Test Workflow';
        $model = new Workflow();
        $trigger = new Trigger();

        return WorkflowLog::createHelper(
            $workflow,
            $model,
            $trigger
        );
    }

    /** @test */
    public function workflowLogCreateHelperIsCreatingATaskLogInDBAndStatusIsStart()
    {

        $workflowLogCreated = $this->getWorkflowLog();

        $this->assertSame($workflowLogCreated->workflow_id, 1);
        $this->assertSame($workflowLogCreated->status, WorkflowLog::$STATUS_START);
    }

    /** @test */
    public function workflowLogSetErrorSetStatusToErrorAndSetErrorMessage()
    {
        $workflowLogCreated = $this->getWorkflowLog();

        $dataBus = new DataBus([]);

        $workflowLogCreated->setError('This is an Error',  $dataBus);

        $this->assertSame($workflowLogCreated->status, WorkflowLog::$STATUS_ERROR);
        $this->assertSame($workflowLogCreated->message, 'This is an Error');
    }

    /** @test */
    public function workflowLogSetToFinish()
    {
        $workflowLogCreated = $this->getWorkflowLog();

        $workflowLogCreated->finish();

        $this->assertSame($workflowLogCreated->status, WorkflowLog::$STATUS_FINISHED);
    }

    /** @test */
    public function workflowLogAddTaskLogAddsArrayToThisTaskLogs()
    {
        $workflowLogCreated = $this->getWorkflowLog();
        $workflowLogCreated->addTaskLog(1,2,'test', TaskLog::$STATUS_START, 'test', Carbon::now());
        $workflowLogCreated->updateTaskLog(2, 'Changed Value', TaskLog::$STATUS_FINISHED, Carbon::now());

        $workflowLogCreated->createTaskLogsFromMemory();

        $taskLog = TaskLog::where('workflow_log_id', 1)->where('task_id', 2)->first();

        $this->assertSame($taskLog->message, 'Changed Value');

    }


}
