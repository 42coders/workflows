<div id="settings-overlay" class="settings-overlay">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="settings-footer text-right">
                    <button class="btn btn-default" onclick="closeSettings();">{{ __('workflows::workflows.Close') }}</button>
                </div>
            </div>
            <div class="col-md-12" style="margin-bottom: 20px;">
                <div class="settings-headline">
                    <h1> {{ __('workflows::workflows.Logs.workflowLogs') }}</h1>
                </div>
            </div>

            <div class="col-md-12">
                <div class="settings-body">
                    <table class="table">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Message</th>
                            <th>Tasks Processed</th>
                            <th>Time in Seconds</th>
                            <th>Start</th>
                            <th>End</th>
                            <th>ReRun</th>
                        </tr>
                        @foreach($workflowLogs as $workflowLog)
                            <tr>
                                <td>{{ $workflowLog->id }}</td>
                                <td>{{ $workflowLog->name }}</td>
                                <td>{{ $workflowLog->status }}</td>
                                <td>{{ $workflowLog->message }}</td>
                                <td>{{ $workflowLog->taskLogs()->count() }} / {{ $workflowLog->workflow->tasks()->count() }}</td>
                                <td>{{ $workflowLog->start->diffInSeconds($workflowLog->end) }}</td>
                                <td>{{ $workflowLog->start }}</td>
                                <td>{{ $workflowLog->end }}</td>
                                <td><button class="btn btn-success" onclick="reRun({{ $workflowLog->id }});">{{ __('workflows::workflows.ReRun') }}</button></td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
            <div class="col-md-12">
                <div class="settings-footer text-right">
                    <button class="btn btn-default" onclick="closeSettings();">{{ __('workflows::workflows.Close') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function reRun(id){
        $.ajax({
            type: "POST",
            url: "{{config('workflows.prefix')}}/workflows/logs/reRun/"+id,
            dataType: "json",
            success: function (data) {
                console.log(data);
            }
        });
    }
</script>
