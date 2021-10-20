<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <!-- Loads and initializes the library -->
    <style>
        @media print {
            #ghostery-purple-box {
                display: none !important
            }
        }
    </style>

    <script src="{{ asset('vendor/workflows/js/workflow.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.3/trix-core.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">


    <!-- Styles -->
    <link href="{{ asset('vendor/workflows/css/workflow.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.3/trix.css" rel="stylesheet">

    <script>


    </script>
    <style>
        #drawflow {
            background-image: url({{ asset('vendor/workflows/img/nature_background.jpeg') }});
        }
    </style>

</head>
<body>
<header>
    <div style="width: 250px; ">
        <a href="{{config('workflows.prefix')}}/workflows"><img src="{{ asset('vendor/workflows/img/42workflows.png') }}" class="img-fluid"/></a>
    </div>
</header>
<div class="wrapper">
    <div class="col">
        @foreach(config('workflows.triggers.types') as $taskName => $taskClass)
            <div class="drag-drawflow" draggable="true" ondragstart="drag(event)" data-node="{{ $taskName }}">
                {!! $taskClass::$icon !!}<span> {{$taskClass::getTranslation() }}</span>
            </div>
        @endforeach
        @foreach(config('workflows.tasks') as $taskName => $taskClass)
            <div class="drag-drawflow" draggable="true" ondragstart="drag(event)" data-node="{{ $taskName }}">
                {!! $taskClass::$icon !!}<span> {{ __('workflows::workflows.Elements.'.$taskName) }}</span>
            </div>
        @endforeach
    </div>
    <div class="col-right">
        <div id="drawflow" ondrop="drop(event)" ondragover="allowDrop(event)">
            <div class="btn-logs">
                <i id="log" class="fas fa-binoculars" onclick="loadLogs()"></i>
            </div>
            <div class="btn-lock">
                <i id="lock" class="fas fa-lock" onclick="editor.editor_mode='fixed'; changeMode('lock');"></i>
                <i id="unlock" class="fas fa-lock-open" onclick="editor.editor_mode='edit'; changeMode('unlock');"
                   style="display:none;"></i>
            </div>
            <div class="bar-zoom">
                <i class="fas fa-search-minus" onclick="editor.zoom_out()"></i>
                <i class="fas fa-search" onclick="editor.zoom_reset()"></i>
                <i class="fas fa-search-plus" onclick="editor.zoom_in()"></i>
            </div>
        </div>
    </div>
</div>
<div id="settings-container" class="settings-container" style="overflow: scroll;">

</div>
<div id="conditions-container" class="settings-container" style="overflow: scroll;">

</div>
<script>
    var id = document.getElementById("drawflow");
    const editor = new Drawflow(id);
    editor.start();

    @foreach($workflow->tasks as $task)
        var new_node = `@include('workflows::layouts.task_node_html', ['elementName' => $task->getTranslation(), 'element' => $task, 'type' => 'task', 'icon' => $task::$icon])`;
        editor.addNode(0, '{{ $task->name }}', 1, 1, {{$task->pos_x}}, {{ $task->pos_y }}, '{{ $task->name }}', {
            task_id: {{$task->id}},
            type: 'task'
        }, new_node);
    @endforeach

    @foreach($workflow->triggers as $trigger)
        var new_node = `@include('workflows::layouts.task_node_html', ['elementName' => $trigger->getTranslation(), 'element' => $trigger, 'type' => 'trigger', 'icon' => $trigger::$icon])`;
        editor.addNode(0, '{{ $trigger->name }}', 0, 1, {{$trigger->pos_x}}, {{ $trigger->pos_y }}, '{{ $trigger->name }}', {
            trigger_id: {{$trigger->id}},
            type: 'trigger'
        }, new_node);

    @endforeach

    function loadResourceIntelligence(element_id, type, value, field_name, element) {

        var resource = $(element).val()
        //var field_name = $(element).attr('name');
        $.ajax({
            type: "POST",
            url: "{{config('workflows.prefix')}}/workflows/settings/{{$workflow->id}}/loadResourceIntelligence",
            dataType: 'json',
            data: {
                'resource': resource,
                'field_name': field_name,
                'value': value,
                'type': type,
                'element_id': element_id,
            },
            dataType: "json",
            success: function (answer) {
                console.log(answer);
                console.log('#' + answer.id);
                console.log($('#' + answer.id).length);
                $('#' + answer.id).html(answer.html);
            }
        });
    }

    function saveConditions(id, type) {
        var data = $('#builder').queryBuilder('getRules');
        console.log(data);
        $.ajax({
            type: "POST",
            url: "{{config('workflows.prefix')}}/workflows/settings/{{$workflow->id}}/changeConditions",
            dataType: 'text',
            data: {
                'data': data,
                'type': type,
                'id': id,
            },
            dataType: "json",
            success: function (answer) {
                console.log(answer);
                //editor.editor_mode = 'edit';
                //changeMode('lock');
                //$('#' + answer.name + '_' + answer.id).modal('hide');
                closeConditions();
            }
        });
    }

    function saveFields(id, type) {
        var data = {};
        $('#settings-overlay').find('.form-control').each(function (index) {
            data[$(this).attr('name')] = $(this).val();
        });
        console.log(data);
        $.ajax({
            type: "POST",
            url: "{{config('workflows.prefix')}}/workflows/settings/{{$workflow->id}}/changeValues",
            dataType: 'text',
            data: {
                'data': data,
                'type': type,
                'id': id,
            },
            dataType: "json",
            success: function (answer) {
                console.log(answer);
                //editor.editor_mode = 'edit';
                //changeMode('lock');
                //$('#' + answer.name + '_' + answer.id).modal('hide');
                closeSettings();
            }
        });

    }

        @foreach($workflow->tasks as $task)
        @if(!empty($task->parentable))
    var parentNode = editor.getNodeByData('{{$task->parentable->family}}_id', {{ $task->parentable->id }});

    var node = editor.getNodeByData('task_id', {{ $task->id }});

    editor.addConnection('node-' + node.id, 'node-' + parentNode.id, 'input_1', 'output_1');
    @endif
    @endforeach

    // Events!
    editor.on('nodeCreated', function (node) {
        console.log('Data Typ: ' + node.data.type);
        console.log('Node Id: ' + node.id);
        switch (node.data.type) {
            case 'task':
                $.ajax({
                    type: "POST",
                    url: "{{config('workflows.prefix')}}/workflows/diagram/{{$workflow->id}}/addTask",
                    data: node,
                    dataType: "json",
                    success: function (data) {
                        console.log('BE: Node ID: ' + data.node_id);
                        console.log('BE: Task ID: ' + data.task.id);
                        editor.setData(data.node_id, 'task_id', data.task.id);
                        $('#node-' + data.node_id).attr('data-task_id', data.task.id);
                    }
                });
                break;
            case 'trigger':
                $.ajax({
                    type: "POST",
                    url: "{{config('workflows.prefix')}}/workflows/diagram/{{$workflow->id}}/addTrigger",
                    data: node,
                    dataType: "json",
                    success: function (data) {
                        editor.setData(data.node_id, 'trigger_id', data.trigger.id);
                        $('#node-' + data.node_id).attr('data-trigger_id', data.trigger.id);
                    }
                });
                break;
        }

    })

    editor.on('nodeBeforeRemoved', function (id) {
        var node = editor.getNode(id);
        $.ajax({
            type: "POST",
            url: "{{config('workflows.prefix')}}/workflows/diagram/{{$workflow->id}}/removeTask",
            data: {
                node: node
            },
            dataType: "json",
            success: function (data) {
                console.log(data);
            }
        });

    })

    var nodeDragDelay = null;

    function updateNodePosition(node) {
        console.log(node);
        $.ajax({
            type: "POST",
            url: "{{config('workflows.prefix')}}/workflows/diagram/{{$workflow->id}}/updateNodePosition",
            data: {
                node: node
            },
            dataType: "json",
            success: function (data) {
                console.log(data);
            }
        });
    }

    editor.on('nodeSelected', function (id) {
        console.log("Node selected " + id);
    })

    editor.on('nodeMoved', function (node) {
        clearTimeout(nodeDragDelay);
        nodeDragDelay = setTimeout(updateNodePosition, 100, node);
    });

    editor.on('moduleCreated', function (name) {
        console.log("Module Created " + name);
    })

    editor.on('moduleChanged', function (name) {
        console.log("Module Changed " + name);
    })

    editor.on('connectionCreated', function (connection) {
        $inputNode = editor.getNode(connection.input_id);
        $outputNode = editor.getNode(connection.ouput_id);
        $.ajax({
            type: "POST",
            url: "{{config('workflows.prefix')}}/workflows/diagram/{{$workflow->id}}/addConnection",
            data: {
                'parent_element': $outputNode,
                'child_element': $inputNode,
            },
            dataType: "json",
            success: function (data) {
                console.log(data);
            }
        });

        console.log('Connection created');
        console.log(connection);
    })

    editor.on('connectionRemoved', function (connection) {
        $.ajax({
            type: "POST",
            url: "{{config('workflows.prefix')}}/workflows/diagram/{{$workflow->id}}/removeConnection",
            data: connection,
            dataType: "json",
            success: function (data) {
                console.log(data);
            }
        });
        console.log('Connection removed');
        console.log(connection);
    })

    editor.on('mouseMove', function (position) {
    })

    editor.on('zoom', function (zoom) {
        console.log('Zoom level ' + zoom);
    })

    editor.on('translate', function (position) {
        //console.log('Translate x:' + position.x + ' y:' + position.y);
    })

    /* DRAG EVENT */

    /* Mouse and Touch Actions */

    var elements = document.getElementsByClassName('drag-drawflow');
    for (var i = 0; i < elements.length; i++) {
        elements[i].addEventListener('touchend', drop, false);
        elements[i].addEventListener('touchmove', positionMobile, false);
        elements[i].addEventListener('touchstart', drag, false);
    }

    var mobile_item_selec = '';
    var mobile_last_move = null;

    function positionMobile(ev) {
        mobile_last_move = event;
    }

    function allowDrop(ev) {
        ev.preventDefault();
    }

    function drag(ev) {
        if (ev.type === "touchstart") {
            mobile_item_selec = ev.target.closest(".drag-drawflow").getAttribute('data-node');
        } else {
            ev.dataTransfer.setData("node", ev.target.getAttribute('data-node'));
        }
    }

    function drop(ev) {
        if (ev.type === "touchend") {
            var parentdrawflow = document.elementFromPoint(mobile_last_move.touches[0].clientX, mobile_last_move.touches[0].clientY).closest("#drawflow");
            if (parentdrawflow != null) {
                addNodeToDrawFlow(mobile_item_selec, mobile_last_move.touches[0].clientX, mobile_last_move.touches[0].clientY);
            }
            mobile_item_selec = '';
        } else {
            ev.preventDefault();
            var data = ev.dataTransfer.getData("node");
            addNodeToDrawFlow(data, ev.clientX, ev.clientY);
        }

    }

    function addNodeToDrawFlow(name, pos_x, pos_y) {
        if (editor.editor_mode === 'fixed') {
            return false;
        }
        pos_x = pos_x * (editor.precanvas.clientWidth / (editor.precanvas.clientWidth * editor.zoom)) - (editor.precanvas.getBoundingClientRect().x * (editor.precanvas.clientWidth / (editor.precanvas.clientWidth * editor.zoom)));
        pos_y = pos_y * (editor.precanvas.clientHeight / (editor.precanvas.clientHeight * editor.zoom)) - (editor.precanvas.getBoundingClientRect().y * (editor.precanvas.clientHeight / (editor.precanvas.clientHeight * editor.zoom)));


        switch (name) {
            @foreach(config('workflows.tasks') as $taskName => $taskClass)
            case '{{ $taskName }}':
                var {{$taskName}}_new_node = `@include('workflows::layouts.task_node_html', ['elementName' => $taskClass::getTranslation(), 'fields' => $taskClass::$fields, 'type' => 'task', 'icon' => $taskClass::$icon])`;
                editor.addNode(0, '{{ $taskName }}', 1, 1, pos_x, pos_y, '{{ $taskName }}', {type: 'task'}, {{$taskName}}_new_node);
                break;
            @endforeach
            @foreach(config('workflows.triggers.types') as $triggerName => $triggerClass)
            case '{{$triggerName}}':
                var {{$taskName}}_new_node = `@include('workflows::layouts.task_node_html', ['elementName' => $triggerClass::getTranslation(), 'fields' => $triggerClass::$fields, 'type' => 'trigger', 'icon' => $triggerClass::$icon])`;
                editor.addNode(0, '{{$triggerName}}', 0, 1, pos_x, pos_y, '{{$triggerName}}', {type: 'trigger'}, {{$taskName}}_new_node);
                break;
            @endforeach
            default:
        }
    }

    var transform = '';

    function showpopup(e) {
        e.target.closest(".drawflow-node").style.zIndex = "9999";
        e.target.children[0].style.display = "block";
        //document.getElementById("modalfix").style.display = "block";

        //e.target.children[0].style.transform = 'translate('+translate.x+'px, '+translate.y+'px)';
        transform = editor.precanvas.style.transform;
        editor.precanvas.style.transform = '';
        editor.precanvas.style.left = editor.canvas_x + 'px';
        editor.precanvas.style.top = editor.canvas_y + 'px';
        console.log(transform);

        //e.target.children[0].style.top  =  -editor.canvas_y - editor.container.offsetTop +'px';
        //e.target.children[0].style.left  =  -editor.canvas_x  - editor.container.offsetLeft +'px';
        editor.editor_mode = "fixed";

    }

    function closemodal(e) {
        e.target.closest(".drawflow-node").style.zIndex = "2";
        e.target.parentElement.parentElement.style.display = "none";
        //document.getElementById("modalfix").style.display = "none";
        editor.precanvas.style.transform = transform;
        editor.precanvas.style.left = '0px';
        editor.precanvas.style.top = '0px';
        editor.editor_mode = "edit";
    }

    function changeModule(event) {
        var all = document.querySelectorAll(".menu ul li");
        for (var i = 0; i < all.length; i++) {
            all[i].classList.remove('selected');
        }
        event.target.classList.add('selected');
    }

    function changeMode(option) {

        //console.log(lock.id);
        if (option == 'lock') {
            lock.style.display = 'none';
            unlock.style.display = 'block';
        } else {
            lock.style.display = 'block';
            unlock.style.display = 'none';
        }

    }

    function closeSettings() {
        $('#settings-container').html('');
        $('#settings-container').fadeOut();
    }

    function closeConditions() {
        $('#conditions-container').html('');
        $('#conditions-container').fadeOut();
    }

    function loadLogs() {
        $.ajax({
            type: "POST",
            url: "{{config('workflows.prefix')}}/workflows/logs/{{$workflow->id}}/getLogs",
            data: {},
            dataType: "text",
            success: function (data) {
                $('#settings-container').html(data);
                $('#settings-container').fadeIn();
            }
        });
    }

    function loadSettings(type, element_id = 0, element) {

        if (element_id == 0) {
            var div = $(element);
            var count = 0;
            while (div.attr('data-type') != type && count < 30) {
                div = div.parent();
                count++;
            }
            element_id = div.attr('data-' + type + '_id');
        }

        $.ajax({
            type: "POST",
            url: "{{config('workflows.prefix')}}/workflows/settings/{{$workflow->id}}/getElementSettings",
            data: {
                type: type,
                element_id: element_id,
            },
            dataType: "text",
            success: function (data) {
                $('#settings-container').html(data);
                $('#settings-container').fadeIn();
            }
        });
    }

    function loadContitions(type, element_id = 0, element) {

        if (element_id == 0) {
            var div = $(element);
            var count = 0;
            while (div.attr('data-type') != type && count < 30) {
                div = div.parent();
                count++;
            }
            element_id = div.attr('data-' + type + '_id');
        }

        $.ajax({
            type: "POST",
            url: "{{config('workflows.prefix')}}/workflows/settings/{{$workflow->id}}/getElementConditions",
            data: {
                type: type,
                element_id: element_id,
            },
            dataType: "text",
            success: function (data) {
                console.log('test');
                $('#conditions-container').html(data);
                $('#conditions-container').fadeIn();
            }
        });
    }


</script>
</body>
</html>
</body>
</html>
