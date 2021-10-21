<?php

namespace the42coders\Workflows;

use Illuminate\Support\Facades\Route;

class Workflows
{
    public static function routes()
    {
        Route::group(['prefix' => 'workflows', 'namespace' => __NAMESPACE__.'\Http\Controllers'], function () {
            Route::get('/', 'WorkflowController@index')->name('workflow.index');
            Route::get('create', 'WorkflowController@create')->name('workflow.create');
            Route::post('store', 'WorkflowController@store')->name('workflow.store');
            Route::get('{id}', 'WorkflowController@show')->name('workflow.show');
            Route::get('{id}/edit', 'WorkflowController@edit')->name('workflow.edit');
            Route::get('{id}/delete', 'WorkflowController@delete')->name('workflow.delete');
            Route::post('{id}/update', 'WorkflowController@update')->name('workflow.update');

            /** diagram routes */
            Route::post('diagram/{id}/addTask', 'WorkflowController@addTask')->name('workflow.addTask');
            Route::post('diagram/{id}/addTrigger', 'WorkflowController@addTrigger')->name('workflow.addTrigger');
            Route::post('diagram/{id}/addConnection', 'WorkflowController@addConnection')->name('workflow.addConnection');
            Route::post('diagram/{id}/removeConnection', 'WorkflowController@removeConnection')->name('workflow.removeConnection');
            Route::post('diagram/{id}/removeTask', 'WorkflowController@removeTask')->name('workflow.removeTask');
            Route::post('diagram/{id}/updateNodePosition', 'WorkflowController@updateNodePosition')->name('workflow.updateNodePosition');

            /** settings routes */
            Route::post('settings/{id}/changeConditions', 'WorkflowController@changeConditions')->name('workflow.changeConditions');
            Route::post('settings/{id}/changeValues', 'WorkflowController@changeValues')->name('workflow.changeValues');
            Route::post('settings/{id}/getElementSettings', 'WorkflowController@getElementSettings')->name('workflow.getSettings');
            Route::post('settings/{id}/getElementConditions', 'WorkflowController@getElementConditions')->name('workflow.getElementConditions');
            Route::post('settings/{id}/loadResourceIntelligence', 'WorkflowController@loadResourceIntelligence')->name('workflow.loadResourceIntelligence');

            /** log routes */
            Route::post('logs/reRun/{workflow_log_id}', 'WorkflowController@reRun')->name('workflow.reRun');
            Route::post('logs/{id}/getLogs', 'WorkflowController@getLogs')->name('workflow.getLogs');

            /** triggers */
            Route::post('button_trigger/execute/{id}', 'WorkflowController@triggerButton')->name('workflows.triggers.button');
        });
    }
}
