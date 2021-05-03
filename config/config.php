<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Styling
    |--------------------------------------------------------------------------
    |
    | To easily integrate the Workflow frontend to your Style you can set your layout and the section.
    |
    */
    'layout' => 'workflows::layouts.workflow_app',
    'section' => 'content',

    /*
    |--------------------------------------------------------------------------
    | Tasks
    |--------------------------------------------------------------------------
    |
    | Here you can register all the Tasks which should be used in the Workflow Package. You can also deactivate Tasks
    | just by deleting them here.
    |
    */
    'tasks' => [
        'SendMail' => The42Coders\Workflows\Tasks\SendMail::class,
        'Execute' => The42Coders\Workflows\Tasks\Execute::class,
        'PregReplace' => The42Coders\Workflows\Tasks\PregReplace::class,
        'HtmlInput' => The42Coders\Workflows\Tasks\HtmlInput::class,
        'DomPDF' => The42Coders\Workflows\Tasks\DomPDF::class,
        'HttpStatus' => The42Coders\Workflows\Tasks\HttpStatus::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Data Resources
    |--------------------------------------------------------------------------
    |
    | Here you can register all the Data Resources which should be used in the Workflow Package. You can also
    | deactivate Data Resources just by deleting them here.
    |
    */
    'data_resources' => [
        'ValueResource' => The42Coders\Workflows\DataBuses\ValueResource::class,
        'ModelResource' => The42Coders\Workflows\DataBuses\ModelResource::class,
        'DataResource' => The42Coders\Workflows\DataBuses\DataBusResource::class,
        'ConfigResource' => The42Coders\Workflows\DataBuses\ConfigResource::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Triggers
    |--------------------------------------------------------------------------
    |
    | Here you can register all the Triggers which should be used in the Workflow Package. You can also
    | deactivate Triggers just by deleting them here.
    |
    | Observers
    |
    | Events:
    | You can register all the events the Trigger should listen to here.
    |
    | Classes:
    | You can register the Classes which can be used for the ObserverTrigger.
    |
    */
    'triggers' => [

        'types' => [
            'ObserverTrigger' => The42Coders\Workflows\Triggers\ObserverTrigger::class,
        ],

        'Observers' => [
            'events' => [
                'retrieved',
                'creating',
                'created',
                'updating',
                'updated',
                'saving',
                'saved',
                'deleting',
                'deleted',
                'restoring',
                'restored',
                'forceDeleted',
            ],
            'classes' => [
                \App\User::class => 'User',
                \The42Coders\Workflows\Loggers\WorkflowLog::class => 'WorkflowLog',
            ],

        ],

    ],
    'queue' => 'redis',

    /*
    |--------------------------------------------------------------------------
    | Routes
    |--------------------------------------------------------------------------
    |
    | Configure if the package should load it's default routes. Default its not using the default routes. We recommend
    | using them as described in the Documentation because you should put a Auth middleware on them.
    */
    'prefix' => '',

    /*
    |--------------------------------------------------------------------------
    | Database prefixing
    |--------------------------------------------------------------------------
    |
    | We know how annoying it can be if a package brings a table name into your system which you are even worse another
    | package all ready uses. With the db_prefix you can set a prefix to the tables to avoid this conflict.
    | This changes needs to be done before the Migrations are running.
    */
    'db_prefix' => '',

];
