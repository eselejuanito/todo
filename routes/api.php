<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'v1'], function () {
    /**
     * Users
     */
    Route::apiResource('users', 'User\UserController');

    /**
     * Todos
     */
    Route::apiResource('todos', 'Todo\TodoController');

    /**
     * Tasks
     */
    Route::apiResource('tasks', 'Task\TaskController');

    /**
     * Assign Tasks
     */
    Route::get('assign', 'Assign\TaskAssignController@index');
    Route::post('assign', 'Assign\TaskAssignController@store');

    /**
     * Comments group and prefix
     */
    Route::prefix('comments')->group(function () {
        Route::name('comments.')->group(function () {
            /**
             * Todo Comments
             */
            Route::apiResource('todos', 'Comment\TodoCommentController');

            /**
             * Task Comments
             */
            Route::apiResource('tasks', 'Comment\TaskCommentController');
        });
    });
});
