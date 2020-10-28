<?php

namespace the42coders\Workflows;

use Illuminate\Support\Facades\Route;

class Workflows
{
    public static function routes()
    {
        Route::get('/workflows/', '\the42coders\Workflows\Http\Controllers\WorkflowController@index')->name('workflow.index');
        Route::get('/workflows/create', '\the42coders\Workflows\Http\Controllers\WorkflowController@create')->name('workflow.create');
        Route::post('/workflows/store', '\the42coders\Workflows\Http\Controllers\WorkflowController@store')->name('workflow.store');
        Route::get('/workflows/{id}', '\the42coders\Workflows\Http\Controllers\WorkflowController@show')->name('workflow.show');
        Route::get('/workflows/{id}/edit', '\the42coders\Workflows\Http\Controllers\WorkflowController@edit')->name('workflow.edit');
        Route::get('/workflows/{id}/delete', '\the42coders\Workflows\Http\Controllers\WorkflowController@delete')->name('workflow.delete');
        Route::post('/workflows/{id}/update', '\the42coders\Workflows\Http\Controllers\WorkflowController@update')->name('workflow.update');

        /** diagram routes */
        Route::post('/workflows/diagram/{id}/addTask', '\the42coders\Workflows\Http\Controllers\WorkflowController@addTask')->name('workflow.addTask');
        Route::post('/workflows/diagram/{id}/addTrigger', '\the42coders\Workflows\Http\Controllers\WorkflowController@addTrigger')->name('workflow.addTrigger');
        Route::post('/workflows/diagram/{id}/addConnection', '\the42coders\Workflows\Http\Controllers\WorkflowController@addConnection')->name('workflow.addConnection');
        Route::post('/workflows/diagram/{id}/removeConnection', '\the42coders\Workflows\Http\Controllers\WorkflowController@removeConnection')->name('workflow.removeConnection');
        Route::post('/workflows/diagram/{id}/removeTask', '\the42coders\Workflows\Http\Controllers\WorkflowController@removeTask')->name('workflow.removeTask');
        Route::post('/workflows/diagram/{id}/updateNodePosition', '\the42coders\Workflows\Http\Controllers\WorkflowController@updateNodePosition')->name('workflow.updateNodePosition');

        /** settings routes */
        Route::post('/workflows/settings/{id}/changeConditions', '\the42coders\Workflows\Http\Controllers\WorkflowController@changeConditions')->name('workflow.changeConditions');
        Route::post('/workflows/settings/{id}/changeValues', '\the42coders\Workflows\Http\Controllers\WorkflowController@changeValues')->name('workflow.changeValues');
        Route::post('/workflows/settings/{id}/getElementSettings', '\the42coders\Workflows\Http\Controllers\WorkflowController@getElementSettings')->name('workflow.getSettings');
        Route::post('/workflows/settings/{id}/getElementConditions', '\the42coders\Workflows\Http\Controllers\WorkflowController@getElementConditions')->name('workflow.getElementConditions');
        Route::post('/workflows/settings/{id}/loadResourceIntelligence', '\the42coders\Workflows\Http\Controllers\WorkflowController@loadResourceIntelligence')->name('workflow.loadResourceIntelligence');

        /** log routes */
        Route::post('/workflows/logs/reRun/{workflow_log_id}', '\the42coders\Workflows\Http\Controllers\WorkflowController@reRun')->name('workflow.reRun');
        Route::post('/workflows/logs/{id}/getLogs', '\the42coders\Workflows\Http\Controllers\WorkflowController@getLogs')->name('workflow.getLogs');

        /** triggers */
        Route::post('/workflows/button_trigger/execute/{id}', '\the42coders\Workflows\Http\Controllers\WorkflowController@triggerButton')->name('workflows.triggers.button');
    }
}
