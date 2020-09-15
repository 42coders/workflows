<?php

namespace the42coders\Workflows;

use Illuminate\Database\Eloquent\Model;

class Workflow extends Model
{
    private $data;

    protected $table = 'workflows';

    protected $fillable = [
        'name',
    ];

    public function __construct(array $attributes = [])
    {
        $this->table = config('workflows.db_prefix').$this->table;
        parent::__construct($attributes);
    }

    public function tasks()
    {
        return $this->hasMany('the42coders\Workflows\Tasks\Task');
    }

    public function triggers()
    {
        return $this->hasMany('the42coders\Workflows\Triggers\Trigger');
    }

    public function logs()
    {
        return $this->hasMany('the42coders\Workflows\Loggers\WorkflowLog');
    }
}
