<?php

/*
 * You can place your custom package configuration in here.
 */
return [
    'tasks' => [
        'SendMail' => the42coders\Workflows\Tasks\SendMail::class,
        'Execute' => the42coders\Workflows\Tasks\Execute::class,
        'PregReplace' => the42coders\Workflows\Tasks\PregReplace::class,
        'HtmlInput' => the42coders\Workflows\Tasks\HtmlInput::class,
        'DomPDF' => the42coders\Workflows\Tasks\DomPDF::class,
        'SaveFile' => the42coders\Workflows\Tasks\SaveFile::class,
        'HttpStatus' => \the42coders\Workflows\Tasks\HttpStatus::class,
    ],
    'data_resources' => [
        'ValueResource' => the42coders\Workflows\DataBuses\ValueResource::class,
        'ModelResource' => the42coders\Workflows\DataBuses\ModelResource::class,
        'DataResource' => the42coders\Workflows\DataBuses\DataBusResource::class,
        'ConfigResource' => the42coders\Workflows\DataBuses\ConfigResource::class,
    ],
    'triggers' => [

        'types' => [
            'ObserverTrigger' => the42coders\Workflows\Triggers\ObserverTrigger::class,
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
                \the42coders\Workflows\Loggers\WorkflowLog::class => 'WorkflowLog',
            ]

        ],

    ],
    'queue' => 'redis',
    'nova' => [
        'resources' => [
            the42coders\Workflows\Nova\Workflow::class,
        ],
        'actions' => [
            new the42coders\Workflows\Nova\Actions\DynamicWorkflow,
        ],
    ]
];
