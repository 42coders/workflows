<?php


namespace the42coders\Workflows\Loggers;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class TaskLog extends Model
{

    static string $STATUS_START = 'start';
    static string $STATUS_FINISHED = 'finished';
    static string $STATUS_ERROR = 'error';

    protected $fillable = [
        'status',
        'workflow_log_id',
        'task_id',
        'name',
        'message',
        'start',
        'end',
    ];

    function __construct(array $attributes = [])
    {
        $this->table = config('workflows.db_prefix').$this->table;
        parent::__construct($attributes);
    }

    static function createHelper(int $workflow_log_id, int $task_id, string $task_name, string $status = null, string $message = '', $start = null, $end = null): TaskLog
    {

        return TaskLog::create([
            'status' => $status ?? self::$STATUS_START,
            'workflow_log_id' => $workflow_log_id,
            'task_id' => $task_id,
            'name' => $task_name,
            'message' => $message,
            'start' => $start ?? Carbon::now(),
            'end' => $end,
        ]);

    }

    public function setError(string $errorMessage)
    {
        $this->message = $errorMessage;
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

}
