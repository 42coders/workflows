<?php


namespace the42coders\Workflows;


use the42coders\Workflows\DataBuses\DataBus;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use the42coders\Workflows\Loggers\TaskLog;

class Workflow extends Model
{

    private DataBus $data;

    protected $table = 'workflows';

    protected $fillable = [
        'name',
    ];

    function __construct(array $attributes = [])
    {
        $this->table = config('workflows.db_prefix').$this->table;
        parent::__construct($attributes);
    }

    public function tasks(){
        return $this->hasMany('the42coders\Workflows\Tasks\Task');
    }

    public function triggers(){
        return $this->hasMany('the42coders\Workflows\Triggers\Trigger');
    }

    public function logs(){
        return $this->hasMany('the42coders\Workflows\Loggers\WorkflowLog');
    }


}
