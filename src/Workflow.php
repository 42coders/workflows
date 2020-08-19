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

    function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    public function tasks(){
        return $this->hasMany('the42coders\Workflows\Tasks\Task');
    }

    public function triggers(){
        return $this->hasMany('the42coders\Workflows\Triggers\Trigger');
    }

    public function conditions(){
        return $this->belongsToMany('the42coders\Workflows\Conditions\Condition');
    }

    public function logs(){
        return $this->hasMany('the42coders\Workflows\Loggers\WorkflowLog');
    }

    /**
     * Run all Actions Attached to this ActionContainer checks first about his  Conditions and then each Action checks its own Conditions
     *
     * @param Model $model
     * @param array $data
     */
    public function handle(Model $model, array $data = [])
    {

    }


}
