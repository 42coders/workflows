<?php


namespace the42coders\Workflows\Tests;

use  Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\View\View;
use the42coders\Workflows\Loggers\WorkflowLog;
use the42coders\Workflows\Tasks\SendMail;
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

    /** @test */
    public function WorkflowControllerCreate()
    {

        $workflowController = new \the42coders\Workflows\Http\Controllers\WorkflowController();

        $this->assertTrue($workflowController->create() instanceof View);
    }

    /** @test */
    public function WorkflowControllerStore()
    {
        $request = new Request(['name' => 'test']);

        $workflowController = new \the42coders\Workflows\Http\Controllers\WorkflowController();

        $workflowController->store($request);

        $this->assertNotTrue(empty(Workflow::where('name', 'test')->first()));
    }

    /** @test */
    public function WorkflowControllerEdit()
    {

        $workflow = Workflow::create(['name' => 'test']);

        $workflowController = new \the42coders\Workflows\Http\Controllers\WorkflowController();

        $this->assertTrue($workflowController->edit(1) instanceof View);
    }

    /** @test */
    public function WorkflowControllerUpdate()
    {

        $workflow = Workflow::create(['name' => 'test']);

        $request = new Request(['name' => 'test_new']);

        $workflowController = new \the42coders\Workflows\Http\Controllers\WorkflowController();

        $workflowController->update($request, $workflow->id);

        $this->assertNotTrue(empty(Workflow::where('name', 'test_new')->first()));
    }

    /** @test */
    public function WorkflowControllerDelete()
    {

        $workflow = Workflow::create(['name' => 'test']);

        $workflowController = new \the42coders\Workflows\Http\Controllers\WorkflowController();

        $workflowController->delete($workflow->id);

        $this->assertTrue(empty(Workflow::where('name', 'test')->first()));
    }

    /** @test */
    public function WorkflowControllerAddNewTask()
    {

        $workflow = Workflow::create(['name' => 'test']);

        $workflowController = new \the42coders\Workflows\Http\Controllers\WorkflowController();

        $request = new Request([
            'data' => ['type' => 'task'],
            'id' => '10',
            'pos_x' => '10',
            'pos_y' => '10',
            'name' => 'SendMail',
        ]);

        $response = $workflowController->addTask($workflow->id, $request);

        $this->assertSame($response['task']->name, 'SendMail');
    }

    /** @test */
    public function WorkflowControllerAddNewTaskDataIsTrigger()
    {

        $workflow = Workflow::create(['name' => 'test']);

        $workflowController = new \the42coders\Workflows\Http\Controllers\WorkflowController();

        $request = new Request([
            'data' => ['type' => 'trigger'],
            'id' => '10',
            'pos_x' => '10',
            'pos_y' => '10',
            'name' => 'SendMail',
        ]);

        $response = $workflowController->addTask($workflow->id, $request);

        $this->assertTrue(empty($response['task']));
    }

    /** @test */
    public function WorkflowControllerAddNewTaskAllreadyExisting()
    {

        $workflow = Workflow::create(['name' => 'test']);

        $workflowController = new \the42coders\Workflows\Http\Controllers\WorkflowController();

        $task = SendMail::create([
            'type' => 'task',
            'workflow_id' => $workflow->id,
            'pos_x' => '10',
            'pos_y' => '10',
            'name' => 'SendMailTest',
            'data_fields' => null,
            'node_id' => '10',
        ]);

        $request = new Request([
            'data' => ['type' => 'task'],
            'id' => '10',
            'pos_x' => '10',
            'pos_y' => '10',
            'name' => 'SendMail',
        ]);

        $response = $workflowController->addTask($workflow->id, $request);

        $this->assertSame($response['task']->name, 'SendMailTest');
    }

    /** @test */
    public function WorkflowControllerAddNewTrigger()
    {

        $workflow = Workflow::create(['name' => 'test']);

        $workflowController = new \the42coders\Workflows\Http\Controllers\WorkflowController();

        $request = new Request([
            'data' => ['type' => 'trigger'],
            'id' => '10',
            'pos_x' => '10',
            'pos_y' => '10',
            'name' => 'ObserverTrigger',
        ]);

        $response = $workflowController->addTrigger($workflow->id, $request);

        $this->assertSame($response['trigger']->name, 'ObserverTrigger');
    }

    /** @test */
    public function WorkflowChangeConditions()
    {

        $workflow = Workflow::create(['name' => 'test']);

        $workflowController = new \the42coders\Workflows\Http\Controllers\WorkflowController();

        $task = SendMail::create([
            'type' => 'task',
            'workflow_id' => $workflow->id,
            'pos_x' => '10',
            'pos_y' => '10',
            'name' => 'SendMailTest',
            'data_fields' => null,
            'node_id' => '10',
        ]);

        $request = new Request([
            'id' => $task->id,
            'type' => 'task',
            'data' => ['type' => 'trigger'],
        ]);

        $response = $workflowController->changeConditions($workflow->id, $request);

        $this->assertSame($response->conditions['type'], 'trigger');
    }

    /** @test */
    public function WorkflowChangeValue()
    {

        $workflow = Workflow::create(['name' => 'test']);

        $workflowController = new \the42coders\Workflows\Http\Controllers\WorkflowController();

        $task = SendMail::create([
            'type' => 'task',
            'workflow_id' => $workflow->id,
            'pos_x' => '10',
            'pos_y' => '10',
            'name' => 'SendMailTest',
            'data_fields' => null,
            'node_id' => '10',
        ]);

        $request = new Request([
            'id' => $task->id,
            'type' => 'task',
            'data' => ['key->value' => 'test'],
        ]);

        $response = $workflowController->changeValues($workflow->id, $request);

        $this->assertSame($response->data_fields['key']['value'], 'test');
    }

    /** @test */
    public function WorkflowUpdateNodePosition()
    {

        $workflow = Workflow::create(['name' => 'test']);

        $workflowController = new \the42coders\Workflows\Http\Controllers\WorkflowController();

        $task = SendMail::create([
            'type' => 'task',
            'workflow_id' => $workflow->id,
            'pos_x' => '10',
            'pos_y' => '10',
            'name' => 'SendMailTest',
            'data_fields' => null,
            'node_id' => '10',
        ]);

        $request = new Request([
            'id' => $task->id,
            'node' => [
                'data' => [
                    'type' => 'task',
                    'task_id' => $task->id,
                ],
                'pos_x' => '11',
                'pos_y' => '11',
            ],
        ]);

        $response = $workflowController->updateNodePosition($workflow->id, $request);

        $this->assertSame($response['status'], 'success');

        $taskNewLoaded = Task::where('id', $task->id)->first();

        $this->assertSame($taskNewLoaded->pos_x, '11');
    }

    /** @test */
    public function WorkflowAddConnectionAndRemoveConnection()
    {

        $workflow = Workflow::create(['name' => 'test']);

        $workflowController = new \the42coders\Workflows\Http\Controllers\WorkflowController();

        $task = SendMail::create([
            'type' => 'task',
            'workflow_id' => $workflow->id,
            'pos_x' => '10',
            'pos_y' => '10',
            'name' => 'SendMailTest',
            'data_fields' => null,
            'node_id' => '10',
        ]);

        $task2 = SendMail::create([
            'type' => 'task',
            'workflow_id' => $workflow->id,
            'pos_x' => '10',
            'pos_y' => '10',
            'name' => 'SendMailTest',
            'data_fields' => null,
            'node_id' => '11',
        ]);

        $request = new Request([
            'parent_element' => [
                'data' => [
                    'type' => 'task',
                    'task_id' => $task->id,
                ],
            ],
            'child_element' => [
                'data' => [
                    'type' => 'task',
                    'task_id' => $task2->id,
                ],
            ],
        ]);

        $response = $workflowController->addConnection($workflow->id, $request);

        $childElement = Task::where('parentable_id', $task->id)->first();

        $this->assertNotTrue(empty($childElement));

        $request2 = new Request([
           'input_id' => '11',
        ]);

        $response2 = $workflowController->removeConnection($workflow->id, $request2);

        $this->assertSame($response2['status'], 'success');

        $orphanTask = Task::where('id', $task2->id)->first();

        $this->assertSame($orphanTask->parentable_id, '0');
    }

    /** @test */
    public function WorkflowRemoveTask()
    {

        $workflow = Workflow::create(['name' => 'test']);

        $workflowController = new \the42coders\Workflows\Http\Controllers\WorkflowController();

        $task = SendMail::create([
            'type' => 'task',
            'workflow_id' => $workflow->id,
            'pos_x' => '10',
            'pos_y' => '10',
            'name' => 'SendMailTest',
            'data_fields' => null,
            'node_id' => '10',
        ]);

        $request = new Request([
            'id' => $task->id,
            'node' => [
                'data' => [
                    'type' => 'task',
                    'task_id' => $task->id,
                ],
                'pos_x' => '11',
                'pos_y' => '11',
            ],
        ]);

        $response = $workflowController->removeTask($workflow->id, $request);

        $this->assertSame($response['status'], 'success');

        $deletedTask = Task::where('id', $task->id)->first();

        $this->assertTrue(empty($deletedTask));

    }

    /** @test */
    public function WorkflowControllerGetElementSettings()
    {

        $workflow = Workflow::create(['name' => 'test']);

        $workflowController = new \the42coders\Workflows\Http\Controllers\WorkflowController();

        $task = SendMail::create([
            'type' => 'task',
            'workflow_id' => $workflow->id,
            'pos_x' => '10',
            'pos_y' => '10',
            'name' => 'SendMailTest',
            'data_fields' => null,
            'node_id' => '10',
        ]);

        $request = new Request([
            'type' => 'task',
            'element_id' => $task->id,
        ]);


        $this->assertTrue($workflowController->getElementSettings($workflow->id, $request) instanceof View);
    }

    /** @test */
    public function WorkflowControllerGetElementConditions()
    {

        $workflow = Workflow::create(['name' => 'test']);

        $workflowController = new \the42coders\Workflows\Http\Controllers\WorkflowController();

        $task = SendMail::create([
            'type' => 'task',
            'workflow_id' => $workflow->id,
            'pos_x' => '10',
            'pos_y' => '10',
            'name' => 'SendMailTest',
            'data_fields' => null,
            'node_id' => '10',
        ]);

        $request = new Request([
            'type' => 'task',
            'element_id' => $task->id,
        ]);


        $this->assertTrue($workflowController->getElementConditions($workflow->id, $request) instanceof View);
    }

    public function WorkflowControllerLoadResourceintelligence()
    {

        $workflow = Workflow::create(['name' => 'test']);

        $workflowController = new \the42coders\Workflows\Http\Controllers\WorkflowController();

        $task = SendMail::create([
            'type' => 'task',
            'workflow_id' => $workflow->id,
            'pos_x' => '10',
            'pos_y' => '10',
            'name' => 'SendMailTest',
            'data_fields' => null,
            'node_id' => '10',
        ]);

        $request = new Request([
            'type' => 'task',
            'element_id' => $task->id,
            'resource' => 'ValueResource',
            'value' => 'value',
            'field_name' => 'name',
        ]);

        $response = $workflowController->loadResourceIntelligence($workflow->id, $request);

        $this->assertJson($response);
    }
}
