<?php

namespace The42Coders\Workflows;

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
        return $this->hasMany('The42Coders\Workflows\Tasks\Task');
    }

    public function triggers()
    {
        return $this->hasMany('The42Coders\Workflows\Triggers\Trigger');
    }

    public function logs()
    {
        return $this->hasMany('The42Coders\Workflows\Loggers\WorkflowLog');
    }
}
