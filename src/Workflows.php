<?php

namespace the42coders\Workflows;

use Illuminate\Support\Facades\Route;

class Workflows
{
    public static function routes()
    {
        Route::group(['prefix' => config('workflows.prefix'), 'namespace' => __NAMESPACE__.'\Http\Controllers'], function () {
            Route::get('/', 'WorkflowController@index')->name('workflow.index');
            Route::get('create', 'WorkflowController@create')->name('workflow.create');
            Route::post('store', 'WorkflowController@store')->name('workflow.store');
            Route::get('{workflow}', 'WorkflowController@show')->name('workflow.show');
            Route::get('{workflow}/edit', 'WorkflowController@edit')->name('workflow.edit');
            Route::get('{workflow}/delete', 'WorkflowController@delete')->name('workflow.delete');
            Route::post('{workflow}/update', 'WorkflowController@update')->name('workflow.update');

            /** diagram routes */
            Route::post('diagram/{workflow}/addTask', 'WorkflowController@addTask')->name('workflow.addTask');
            Route::post('diagram/{workflow}/addTrigger', 'WorkflowController@addTrigger')->name('workflow.addTrigger');
            Route::post('diagram/{workflow}/addConnection', 'WorkflowController@addConnection')->name('workflow.addConnection');
            Route::post('diagram/{workflow}/removeConnection', 'WorkflowController@removeConnection')->name('workflow.removeConnection');
            Route::post('diagram/{workflow}/removeTask', 'WorkflowController@removeTask')->name('workflow.removeTask');
            Route::post('diagram/{workflow}/updateNodePosition', 'WorkflowController@updateNodePosition')->name('workflow.updateNodePosition');

            /** settings routes */
            Route::post('settings/{workflow}/changeConditions', 'WorkflowController@changeConditions')->name('workflow.changeConditions');
            Route::post('settings/{workflow}/changeValues', 'WorkflowController@changeValues')->name('workflow.changeValues');
            Route::post('settings/{workflow}/getElementSettings', 'WorkflowController@getElementSettings')->name('workflow.getElementSettings');
            Route::post('settings/{workflow}/getElementConditions', 'WorkflowController@getElementConditions')->name('workflow.getElementConditions');
            Route::post('settings/{workflow}/loadResourceIntelligence', 'WorkflowController@loadResourceIntelligence')->name('workflow.loadResourceIntelligence');

            /** log routes */
            Route::post('logs/reRun/{workflow_log_id}', 'WorkflowController@reRun')->name('workflow.reRun');
            Route::post('logs/reRun/', 'WorkflowController@reRun')->name('workflow.reRunJSHelper');
            Route::post('logs/{workflow}/getLogs', 'WorkflowController@getLogs')->name('workflow.getLogs');

            /** triggers */
            Route::post('button_trigger/execute/{id}', 'WorkflowController@triggerButton')->name('workflows.triggers.button');
        });
    }
}
