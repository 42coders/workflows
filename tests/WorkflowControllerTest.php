<?php


namespace the42coders\Workflows\Tests;

use Illuminate\Routing\Route;
use Illuminate\View\View;
use the42coders\Workflows\Loggers\WorkflowLog;
use the42coders\Workflows\Tasks\Task;
use the42coders\Workflows\Triggers\ObserverTrigger;
use the42coders\Workflows\Workflow;
use the42coders\Workflows\Workflows;

class WorkflowControllerTest extends TestCase
{

    /** @test */
    public function WorkflowControllerIndex()
    {

        $workflowController = new \the42coders\Workflows\Http\Controllers\WorkflowController();

        $this->assertTrue($workflowController->index() instanceof View);
    }

    /** @test */
    public function WorkflowControllerShow()
    {

        $workflow = Workflow::create(['name' => 'test']);

        $workflowController = new \the42coders\Workflows\Http\Controllers\WorkflowController();

        $this->assertTrue($workflowController->show(1) instanceof View);
    }

}
