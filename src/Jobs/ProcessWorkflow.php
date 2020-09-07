<?php

namespace the42coders\Workflows\Jobs;

use the42coders\Workflows\DataBuses\DataBus;
use the42coders\Workflows\Loggers\TaskLog;
use the42coders\Workflows\Loggers\WorkflowLog;
use the42coders\Workflows\Triggers\Trigger;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use the42coders\Exceptions\ConditionFailedError;

class ProcessWorkflow implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $model;
    protected $dataBus;
    protected $trigger;
    protected $log;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Model $model, DataBus $dataBus, Trigger $trigger, WorkflowLog $log)
    {
        $this->model = $model;
        $this->dataBus = $dataBus;
        $this->trigger = $trigger;
        $this->log = $log;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        DB::beginTransaction();
        try {
            foreach ($this->trigger->children as $task) {
                $task->init($this->model, $this->dataBus, $this->log);
                $task->execute();
                $task->pastExecute();
            }
        }catch (\Throwable $e) {
            DB::rollBack();
            $this->log->setError($e->getMessage(), $this->dataBus);
            $this->log->createTaskLogsFromMemory();
            //dd($e);
        }

        $this->log->finish();
        DB::commit();
    }
}
