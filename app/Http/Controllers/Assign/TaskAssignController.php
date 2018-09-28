<?php

namespace App\Http\Controllers\Assign;

use App\Http\Requests\TaskAssignRequest;
use App\TaskAssigned;
use App\Task;
use App\Transformers\TaskAssignTransformer;
use App\Http\Controllers\ApiController;
use App\User;
use Illuminate\Http\Response;

/**
 * Class TaskAssignController
 * @package App\Http\Controllers\Comment
 */
class TaskAssignController extends ApiController
{
    public function __construct()
    {
        $this->middleware('transform.input:' . TaskAssignTransformer::class)->only(['store']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $tasks_assigned = TaskAssigned::all();
        return $this->getAll($tasks_assigned);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\TaskAssignRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(TaskAssignRequest $request)
    {
        $data = $request->all();
        $user = User::find($data['user_id']);
        if ($user == null) {
            return $this->errorResponse("User doesn't exist", Response::HTTP_NOT_FOUND);
        }

        $task = Task::find($data['task_id']);
        if ($task == null) {
            return $this->errorResponse("Task doesn't exist", Response::HTTP_NOT_FOUND);
        }

        $counter = TaskAssigned::where('user_id', $user->id)
            ->where('task_id', $task->id)->count();

        if ($counter > 0) {
            return $this->errorResponse("This task is already assigned to this user.", Response::HTTP_NOT_ACCEPTABLE);
        }

        $task_assigned = TaskAssigned::create($data);
        return $this->getOne($task_assigned, Response::HTTP_CREATED);
    }
}
