<?php


namespace the42coders\Workflows\Tests;

use Illuminate\Routing\Route;
use the42coders\Workflows\Loggers\WorkflowLog;
use the42coders\Workflows\Tasks\Task;
use the42coders\Workflows\Triggers\ObserverTrigger;
use the42coders\Workflows\Workflow;
use the42coders\Workflows\Workflows;

class WorkflowTest extends TestCase
{

    private function createBaseSetupForWorkflows()
    {
        $workflow = Workflow::create(['name' => 'TestWorkflow']);
        $trigger = ObserverTrigger::create([
            'type' => 'the42coders\Workflows\Triggers\ObserverTrigger',
            'name' => 'ObserverTrigger',
            'queueable' => 1,
            'data_fields' => '{}',
            'workflow_id' => $workflow->id,
            'pos_x' => 10,
            'pos_y' => 10,
        ]);
        $task = Task::create([
            'workflow_id' => $workflow->id,
            'type' => 'the42coders\Workflows\Tasks\HttpStatus',
            'name' => 'HttpStatus',
            'data_fields' => '{
	"url": {
		"type": "the42coders\\Workflows\\DataBuses\\ValueResource",
		"value": "https://42coders.com"
	},
	"description": {
		"value": "Check if 42coders website is online"
	},
	"http_status": {
		"value": "42_coders_status"
	}
}',
            'node_id' => 1,
            'pos_x' => 100,
            'pos_y' => 10,

        ]);

        $task->parentable_id = $trigger->id;
        $task->parentable_type = get_class($trigger);

        $task->save();

        $logCreated = WorkflowLog::createHelper(
            $workflow,
            $workflow,
            $trigger
        );

        return $workflow;
    }

    /** @test */
    public function workflowCanHaveTasks()
    {

        $workflow = $this->createBaseSetupForWorkflows();


        $this->assertTrue(!empty($workflow->tasks));
    }

    /** @test */
    public function workflowCanHaveTriggers()
    {

        $workflow = $this->createBaseSetupForWorkflows();

        $this->assertTrue(!empty($workflow->triggers));
    }

    /** @test */
    public function workflowCanHaveLogs()
    {

        $workflow = $this->createBaseSetupForWorkflows();

        $this->assertTrue(!empty($workflow->logs));
    }


    /*public function getRoutes()
    {
        //Workflows::routes();

        $this->get('/workflows/index')
            ->assertStatus(200);
    }*/

    /** @test */
    public function workflowCanBeStarted()
    {
        $workflow = $this->createBaseSetupForWorkflows();

        $logCountBefore = $workflow->logs()->count();

        $workflow->triggers->first()->start($workflow, []);

        $logCountAfter = $workflow->logs()->count();

        $this->assertTrue($logCountAfter > $logCountBefore);
    }



}
