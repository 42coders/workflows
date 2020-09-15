<?php


namespace the42coders\Workflows\Loggers;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use the42coders\Workflows\DataBuses\DataBus;
use the42coders\Workflows\Triggers\WorkflowObservable;

class WorkflowLog extends Model
{

    use WorkflowObservable;

    protected $table = 'workflow_logs';

    static $STATUS_START = 'start';
    static $STATUS_FINISHED = 'finished';
    static $STATUS_ERROR = 'error';

    private $taskLogsArray = [];

    protected $dates = [
        'start',
        'end',
    ];

    protected $fillable = [
        'workflow_id',
        'name',
        'status',
        'message',
        'start',
        'elementable_id',
        'elementable_type',
        'triggerable_id',
        'triggerable_type',
    ];

    function __construct(array $attributes = [])
    {
        $this->table = config('workflows.db_prefix').$this->table;
        parent::__construct($attributes);
    }

    public function workflow(){
        return $this->belongsTo('the42coders\Workflows\Workflow');
    }

    public function taskLogs(){
        return $this->hasMany('the42coders\Workflows\Loggers\TaskLog');
    }

    public function elementable(){
        return $this->morphTo();
    }

    public function triggerable(){
        return $this->morphTo();
    }

    static function createHelper(Model $workflow, Model $element, $trigger): WorkflowLog
    {
        return WorkflowLog::create([
            'workflow_id' => $workflow->id,
            'name' => $workflow->name,
            'elementable_id' => $element->id,
            'elementable_type' => get_class($element),
            'triggerable_id' => $trigger->id,
            'triggerable_type' => get_class($trigger),
            'status' => self::$STATUS_START,
            'message' => '',
            'start' => Carbon::now(),
        ]);
    }

    public function setError(string $errorMessage, DataBus $dataBus)
    {
        $this->message = $errorMessage;
        //$this->databus = $dataBus->toString();
        $this->status = self::$STATUS_ERROR;
        $this->end = Carbon::now();
        $this->save();
    }

    public function finish()
    {
        $this->status = self::$STATUS_FINISHED;
        $this->end = Carbon::now();
        $this->save();
    }

    public function addTaskLog(int $workflow_log_id, int $task_id, string $task_name, string $status, string $message, $start, $end = null)
    {
        $this->taskLogsArray[$task_id] = [
            'workflow_log_id' => $workflow_log_id,
            'task_id' => $task_id,
            'task_name' => $task_name,
            'status' => $status,
            'message' => $message,
            'start' => $start,
            'end' => $end,
        ];
    }

    public function updateTaskLog(int $task_id, string $message, string $status, \DateTime $end)
    {
        $this->taskLogsArray[$task_id]['message'] = $message;
        $this->taskLogsArray[$task_id]['status'] = $status;
        $this->taskLogsArray[$task_id]['end'] = $end;
    }

    public function createTaskLogsFromMemory()
    {
        foreach ($this->taskLogsArray as $taskLog) {
            TaskLog::updateOrCreate(
                [
                    'workflow_log_id' => $taskLog['workflow_log_id'],
                    'task_id' => $taskLog['task_id'],
                ],
                [
                    'name' => $taskLog['task_name'],
                    'status' => $taskLog['status'],
                    'message' => $taskLog['message'],
                    'start' => $taskLog['start'],
                    'end' => $taskLog['end'],
                ]
            );
        }
    }
}
