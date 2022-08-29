<?php

namespace the42coders\Workflows\Tests;

use Illuminate\Support\Facades\Config;
use the42coders\Workflows\DataBuses\DataBus;
use the42coders\Workflows\Loggers\WorkflowLog;
use the42coders\Workflows\Tasks\DomPDF;
use the42coders\Workflows\Tasks\Execute;
use the42coders\Workflows\Tasks\HtmlInput;
use the42coders\Workflows\Tasks\HttpStatus;
use the42coders\Workflows\Tasks\PregReplace;
use the42coders\Workflows\Tasks\SendMail;
use the42coders\Workflows\Tasks\Task;
use the42coders\Workflows\Triggers\ObserverTrigger;
use the42coders\Workflows\Workflow;

class TasksTest extends TestCase
{
    private function createBaseSetupForTasks()
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

        $taskChild = Task::create([
            'workflow_id' => $workflow->id,
            'type' => 'the42coders\Workflows\Tasks\SendMail',
            'name' => 'SendMail',
            'data_fields' => '{
	"sender": {
		"type": "the42coders\\Workflows\\DataBuses\\ValueResource",
		"value": "system@42coders.com"
	},
	"content": {
		"type": "the42coders\\Workflows\\DataBuses\\ValueResource",
		"value": "The content of the Mail"
	},
	"subject": {
		"type": "the42coders\\Workflows\\DataBuses\\ValueResource",
		"value": "Testing the Package"
	},
	"recipients": {
		"type": "the42coders\\Workflows\\DataBuses\\ValueResource",
		"value": "max@42coders.com"
	},
	"description": {
		"value": "Send mail to Test the Workflow Package"
	}
}',
            'node_id' => 1,
            'pos_x' => 100,
            'pos_y' => 10,

        ]);

        $taskChild->parentable_id = $task->id;
        $taskChild->parentable_type = get_class($task);

        $taskChild->save();

        $logCreated = WorkflowLog::createHelper(
            $workflow,
            $workflow,
            $trigger
        );

        return $workflow;
    }

    /** @test */
    public function TaskHaveParent()
    {
        $workflow = $this->createBaseSetupForTasks();

        $task = $workflow->tasks->first();

        $this->assertTrue(! empty($task->parentable));
    }

    /** @test */
    public function TaskHaveChildren()
    {
        $workflow = $this->createBaseSetupForTasks();

        $task = $workflow->tasks->first();

        $this->assertTrue(! empty($task->children));
    }

    /** @test */
    public function TaskHaveWorkflow()
    {
        $workflow = $this->createBaseSetupForTasks();

        $task = $workflow->tasks->first();

        $this->assertTrue(! empty($task->workflow));
    }

    /** @test */
    public function TaskEmtpyConditionsCheckIsTrue()
    {
        $task = new Task();

        $this->assertTrue($task->checkConditions($task, new DataBus([])));
    }

    /** @test */
    public function TaskConditionsCheckIsTrue()
    {
        $task = new Task();
        $task->conditions = '{
	"rules": [
		{
			"id": "ValueResource-test_bus",
			"type": "string",
			"field": "HttpStatus - HTTP Status - 42_coders_status",
			"input": "text",
			"value": "test",
			"operator": "equal"
		}
	],
	"valid": "true",
	"condition": "AND"
}';

        $this->assertTrue($task->checkConditions($task, new DataBus(['test_bus' => 'test'])));
    }

    /** @test */
    public function TaskConditionsCheckIsThrowingAnError()
    {
        $task = new Task();
        $task->conditions = '{
	"rules": [
		{
			"id": "ValueResource-test_bus",
			"type": "string",
			"field": "HttpStatus - HTTP Status - 42_coders_status",
			"input": "text",
			"value": "test",
			"operator": "equal"
		}
	],
	"valid": "true",
	"condition": "AND"
}';
        $this->expectException(\Exception::class);
        $task->checkConditions($task, new DataBus(['test_bus' => 'failed assertion']));
    }

    /** @test */
    public function TaskSettingsCanBeLoaded()
    {
        $task = new Task();

        $this->assertStringContainsString(__('workflows::workflows.Settings'), $task->getSettings());
    }

    /** @test */
    public function TaskSendMail()
    {
        Config::set('mail.default', 'log');

        $task = new SendMail();

        $dataBus = new DataBus([
            'content' => 'Mail Content',
            'subject' => 'Mail Subject',
            'recipients' => 'max@42coders.com',
            'sender' => 'system@42coders.com',
        ]);

        $task->dataBus = $dataBus;

        $task->execute();

        $this->assertTrue(true);
    }

    /** @test */
    public function TaskDomPDF()
    {
        $task = new DomPDF();

        $dataBus = new DataBus([
            'html' => '<h1>Test PDF</h1>',
        ]);

        $task->dataBus = $dataBus;

        $task->execute();

        $this->assertTrue(is_array($task->getData('pdf_file')));
    }

    /** @test */
    public function TaskExecute()
    {
        $task = new Execute();

        $dataBus = new DataBus([
            'command' => 'echo test',
        ]);

        $task->dataBus = $dataBus;

        $task->execute();

        $this->assertSame($task->getData('command_output'), "test\n");
    }

    /** @test */
    public function HtmlInput()
    {
        $task = new HtmlInput();

        $dataBus = new DataBus([
            'test' => '1234',
            'html' => '<h1>test {{ $dataBus->get(\'test\') }}</h1>',
        ]);

        $task->dataBus = $dataBus;
        $task->inputFields();
        $task->execute();

        $this->assertSame($task->getData('html_output'), '<h1>test 1234</h1>');
    }

    /** @test */
    public function HttpStatus()
    {
        $task = new HttpStatus();

        $dataBus = new DataBus([
            'url' => 'https://42coders.com',
        ]);

        $task->dataBus = $dataBus;

        $task->execute();

        $this->assertSame($task->getData('http_status'), 200);
    }

    /** @test */
    public function PregReplace()
    {
        $task = new PregReplace();

        $dataBus = new DataBus([
            'pattern' => '/3/',
            'replacement' => '42',
            'subject' => '3coders',
        ]);

        $task->dataBus = $dataBus;

        $task->execute();

        $this->assertSame($task->getData('preg_replace_output'), '42coders');
    }
}
