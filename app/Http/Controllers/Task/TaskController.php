<?php

namespace App\Http\Controllers\Task;

use App\Http\Requests\TaskRequest;
use App\Transformers\TaskTransformer;
use App\Task;
use App\Http\Controllers\ApiController;
use App\Todo;

/**
 * Class TaskController
 * @package App\Http\Controllers\Task
 */
class TaskController extends ApiController
{
    public function __construct()
    {
        $this->middleware('transform.input:' . TaskTransformer::class)->only(['store', 'update']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $tasks = Task::all();
        return $this->getAll($tasks);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\TaskRequest
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(TaskRequest $request)
    {
        $data = $request->all();
        $todo = Todo::find($data['todo_id']);
        if ($todo == null) {
            return $this->errorResponse("Todo doesn't exist", 404);
        }

        $task = Task::create($data);
        return $this->getOne($task, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Task $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Task $task)
    {
        return $this->getOne($task);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  Task $task
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return $this->getOne($task);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\TaskRequest $request
     * @param  Task $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(TaskRequest $request, Task $task)
    {
        if ($request->has('todo_id')) {
            $todo = Todo::find($request->todo_id);
            if ($todo == null) {
                return $this->errorResponse("Todo doesn't exist", 404);
            }

            $task->todo_id = $request->todo_id;
        }

        if ($request->has('name')) {
            $task->name = $request->name;
        }

        if ($request->has('description')) {
            $task->description = $request->description;
        }

        if (!$task->isDirty()) {
            return $this->errorResponse('You need to specify a different value to update', 422);
        }

        $task->save();

        return $this->getOne($task);
    }
}
