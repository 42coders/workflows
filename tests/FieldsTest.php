<?php


namespace the42coders\Workflows\Tests;

use the42coders\Workflows\Fields\TrixInputField;
use the42coders\Workflows\Loggers\TaskLog;
use the42coders\Workflows\Tasks\Task;
use the42coders\Workflows\Triggers\ObserverTrigger;
use the42coders\Workflows\Triggers\Trigger;
use the42coders\Workflows\Workflows;
use the42coders\Workflows\WorkflowsServiceProvider;

class FieldsTest extends TestCase
{
    /** @test */
    public function fieldTest()
    {
        $this->assertTrue(true);
    }


}
