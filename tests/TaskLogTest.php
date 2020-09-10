<?php


namespace the42coders\Workflows\Tests;

use the42coders\Workflows\Loggers\TaskLog;
use the42coders\Workflows\Workflows;
use the42coders\Workflows\WorkflowsServiceProvider;

class TaskLogTest extends TestCase
{
    /** @test */
    public function taskLogCreateHelperIsCreatingATaskLogInDBAndStatusIsStart()
    {
        $taskLogCreated = TaskLog::createHelper(
            1, //workflow_log_id
            1, //task_id
            'test', //task_name
        );
        $this->assertSame($taskLogCreated->workflow_log_id, 1);
        $this->assertSame($taskLogCreated->status, TaskLog::$STATUS_START);
    }

    /** @test */
    public function taskLogSetErrorSetStatusToErrorAndSetErrorMessage()
    {
        $taskLogCreated = TaskLog::createHelper(
            1, //workflow_log_id
            1, //task_id
            'test', //task_name
        );

        $taskLogCreated->setError('This is an Error');

        $this->assertSame($taskLogCreated->status, TaskLog::$STATUS_ERROR);
        $this->assertSame($taskLogCreated->message, 'This is an Error');
    }

    /** @test */
    public function taskLogSetToFinish()
    {
        $taskLogCreated = TaskLog::createHelper(
            1, //workflow_log_id
            1, //task_id
            'test', //task_name
        );

        $taskLogCreated->finish();

        $this->assertSame($taskLogCreated->status, TaskLog::$STATUS_FINISHED);
    }

}
