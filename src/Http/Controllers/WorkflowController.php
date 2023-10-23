<?php

namespace the42coders\Workflows\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use the42coders\Workflows\Loggers\WorkflowLog;
use the42coders\Workflows\Tasks\Task;
use the42coders\Workflows\Triggers\ReRunTrigger;
use the42coders\Workflows\Triggers\Trigger;
//use App\Http\Controllers\Controller;
use the42coders\Workflows\Workflow;

class WorkflowController extends Controller
{
    public function index()
    {
        $workflows = Workflow::paginate(25);

        return view('workflows::index', ['workflows' => $workflows]);
    }

    public function show($id)
    {
        $workflow = Workflow::find($id);

        return view('workflows::diagram', ['workflow' => $workflow]);
    }

    public function create()
    {
        return view('workflows::create');
    }

    public function store(Request $request)
    {
        $workflow = Workflow::create($request->all());

        return redirect(route('workflow.show', ['workflow' => $workflow]));
    }

    public function edit($id)
    {
        $workflow = Workflow::find($id);

        return view('workflows::edit', [
            'workflow' => $workflow,
        ]);
    }

    public function update(Request $request, $id)
    {
        $workflow = Workflow::find($id);

        $workflow->update($request->all());

        return redirect(route('workflow.index'));
    }

    /**
     * Deletes the Workflow and over cascading also the Tasks, TaskLogs, WorkflowLogs and Triggers.
     *
     * @param  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete($id)
    {
        $workflow = Workflow::find($id);

        $workflow->delete();

        return redirect(route('workflow.index'));
    }

    public function addTask($id, Request $request)
    {
        $workflow = Workflow::find($id);
        if ($request->data['type'] == 'trigger') {
            return [
                'task' => '',
            ];
        }
        $task = Task::where('workflow_id', $workflow->id)->where('node_id', $request->id)->first();

        if (! empty($task)) {
            $task->pos_x = $request->pos_x;
            $task->pos_y = $request->pos_y;
            $task->save();

            return ['task' => $task];
        }

        if (array_key_exists($request->name, config('workflows.tasks'))) {
            $task = config('workflows.tasks')[$request->name]::create([
                'type' => config('workflows.tasks')[$request->name],
                'workflow_id' => $workflow->id,
                'name' => $request->name,
                'data_fields' => null,
                'node_id' => $request->id,
                'pos_x' => $request->pos_x,
                'pos_y' => $request->pos_y,
            ]);
        }

        return [
            'task' => $task,
            'node_id' => $request->id,
        ];
    }

    public function addTrigger($id, Request $request)
    {
        $workflow = Workflow::find($id);

        if (array_key_exists($request->name, config('workflows.triggers.types'))) {
            $trigger = config('workflows.triggers.types')[$request->name]::create([
                'type' => config('workflows.triggers.types')[$request->name],
                'workflow_id' => $workflow->id,
                'name' => $request->name,
                'data_fields' => null,
                'pos_x' => $request->pos_x,
                'pos_y' => $request->pos_y,
            ]);
        }

        return [
            'trigger' => $trigger,
            'node_id' => $request->id,
        ];
    }

    public function changeConditions($id, Request $request)
    {
        $workflow = Workflow::find($id);

        if ($request->type == 'task') {
            $element = $workflow->tasks->find($request->id);
        }

        if ($request->type == 'trigger') {
            $element = $workflow->triggers->find($request->id);
        }

        $element->conditions = $request->data;
        $element->save();

        return $element;
    }

    public function changeValues($id, Request $request)
    {
        $workflow = Workflow::find($id);

        if ($request->type == 'task') {
            $element = $workflow->tasks->find($request->id);
        }

        if ($request->type == 'trigger') {
            $element = $workflow->triggers->find($request->id);
        }

        $data = [];

        foreach ($request->data as $key => $value) {
            $path = explode('->', $key);
            $data[$path[0]][$path[1]] = $value;
        }
        $element->data_fields = $data;
        $element->save();

        return $element;
    }

    public function updateNodePosition($id, Request $request)
    {
        $element = $this->getElementByNode($id, $request->node);

        $element->pos_x = $request->node['pos_x'];
        $element->pos_y = $request->node['pos_y'];
        $element->save();

        return ['status' => 'success'];
    }

    public function getElementByNode($workflow_id, $node)
    {
        if ($node['data']['type'] == 'task') {
            $element = Task::where('workflow_id', $workflow_id)->where('id', $node['data']['task_id'])->first();
        }

        if ($node['data']['type'] == 'trigger') {
            $element = Trigger::where('workflow_id', $workflow_id)->where('id', $node['data']['trigger_id'])->first();
        }

        return $element;
    }

    public function addConnection($id, Request $request)
    {
        $workflow = Workflow::find($id);

        if ($request->parent_element['data']['type'] == 'trigger') {
            $parentElement = Trigger::where('workflow_id', $workflow->id)->where('id', $request->parent_element['data']['trigger_id'])->first();
        }
        if ($request->parent_element['data']['type'] == 'task') {
            $parentElement = Task::where('workflow_id', $workflow->id)->where('id', $request->parent_element['data']['task_id'])->first();
        }
        if ($request->child_element['data']['type'] == 'trigger') {
            $childElement = Trigger::where('workflow_id', $workflow->id)->where('id', $request->child_element['data']['trigger_id'])->first();
        }
        if ($request->child_element['data']['type'] == 'task') {
            $childElement = Task::where('workflow_id', $workflow->id)->where('id', $request->child_element['data']['task_id'])->first();
        }

        $childElement->parentable_id = $parentElement->id;
        $childElement->parentable_type = get_class($parentElement);

        $childElement->save();

        return ['status' => 'success'];
    }

    public function removeConnection($id, Request $request)
    {
        $workflow = Workflow::find($id);

        $childTask = Task::where('workflow_id', $workflow->id)->where('node_id', $request->input_id)->first();

        $childTask->parentable_id = 0;
        $childTask->parentable_type = null;
        $childTask->save();

        return ['status' => 'success'];
    }

    public function removeTask($id, Request $request)
    {
        $workflow = Workflow::find($id);

        $element = $this->getElementByNode($id, $request->node);

        $element->delete();

        return [
            'status' => 'success',
        ];
    }

    public function getElementSettings($id, Request $request)
    {
        $workflow = Workflow::find($id);

        if ($request->type == 'task') {
            $element = Task::where('workflow_id', $workflow->id)->where('id', $request->element_id)->first();
        }
        if ($request->type == 'trigger') {
            $element = Trigger::where('workflow_id', $workflow->id)->where('id', $request->element_id)->first();
        }

        return view('workflows::layouts.settings_overlay', [
            'element' => $element,
        ]);
    }

    public function getElementConditions($id, Request $request)
    {
        $workflow = Workflow::find($id);

        if ($request->type == 'task') {
            $element = Task::where('workflow_id', $workflow->id)->where('id', $request->element_id)->first();
        }
        if ($request->type == 'trigger') {
            $element = Trigger::where('workflow_id', $workflow->id)->where('id', $request->element_id)->first();
        }

        $filter = [];

        foreach (config('workflows.data_resources') as $resourceName => $resourceClass) {
            $filter[$resourceName] = $resourceClass::getValues($element, null, null);
        }

        return view('workflows::layouts.conditions_overlay', [
            'element' => $element,
            'conditions' => $element->conditions,
            'allFilters' => $filter,
        ]);
    }

    public function loadResourceIntelligence($id, Request $request)
    {
        $workflow = Workflow::find($id);

        if ($request->type == 'task') {
            $element = Task::where('workflow_id', $workflow->id)->where('id', $request->element_id)->first();
        }
        if ($request->type == 'trigger') {
            $element = Trigger::where('workflow_id', $workflow->id)->where('id', $request->element_id)->first();
        }

        if (in_array($request->resource, config('workflows.data_resources'))) {
            $className = $request->resource ?? 'the42coders\\Workflows\\DataBuses\\ValueResource';
            $resource = new $className();
            $html = $resource->loadResourceIntelligence($element, $request->value, $request->field_name);
        }

        return response()->json([
            'html' => $html,
            'id' => $request->field_name,
        ]);
    }

    public function getLogs($id)
    {
        $workflow = Workflow::find($id);

        $workflowLogs = $workflow->logs()->orderBy('start', 'desc')->get();
        //TODO: get Pagination working

        return view('workflows::layouts.logs_overlay', [
            'workflowLogs' => $workflowLogs,
        ]);
    }

    public function reRun($workflowLogId)
    {
        $log = WorkflowLog::find($workflowLogId);

        ReRunTrigger::startWorkflow($log);

        return [
            'status' => 'started',
        ];
    }

    public function triggerButton(Request $request, $triggerId)
    {
        $trigger = Trigger::findOrFail($triggerId);
        $className = $request->model_class;
        $resource = new $className();

        $model = $resource->find($request->model_id);

        $trigger->start($model, []);

        return redirect()->back()->with('sucess', 'Button Triggered a Workflow');
    }
}
