<?php

namespace App\Http\Controllers\Comment;

use App\Http\Requests\TaskCommentRequest;
use App\TaskComment;
use App\Task;
use App\Transformers\TaskCommentTransformer;
use App\Http\Controllers\ApiController;
use App\User;

/**
 * Class TaskCommentController
 * @package App\Http\Controllers\Comment
 */
class TaskCommentController extends ApiController
{
    public function __construct()
    {
        $this->middleware('transform.input:' . TaskCommentTransformer::class)->only(['store', 'update']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $todo_comments = TaskComment::all();
        return $this->getAll($todo_comments);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\TaskCommentRequest
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(TaskCommentRequest $request)
    {
        $data = $request->all();
        $user = User::find($data['user_id']);
        if ($user == null) {
            return $this->errorResponse("User doesn't exist", 404);
        }

        $task = Task::find($data['task_id']);
        if ($task == null) {
            return $this->errorResponse("Task doesn't exist", 404);
        }

        $task_comment = TaskComment::create($data);
        return $this->getOne($task_comment, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param TaskComment $task_comment
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($task_comment)
    {
        $task_comment = TaskComment::find($task_comment);
        if ($task_comment == null) {
            return $this->errorResponse("Comment doesn't exist", 404);
        }
        return $this->getOne($task_comment);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  TaskComment $task_comment
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy($task_comment)
    {
        $task_comment = TaskComment::find($task_comment);
        if ($task_comment == null) {
            return $this->errorResponse("Comment doesn't exist", 404);
        }

        $task_comment->delete();
        return $this->getOne($task_comment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\TaskCommentRequest $request
     * @param  TaskComment $task_comment
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(TaskCommentRequest $request, $task_comment)
    {
        $task_comment = TaskComment::find($task_comment);
        if ($task_comment == null) {
            return $this->errorResponse("Comment doesn't exist", 404);
        }

        if ($request->has('user_id')) {
            $user = User::find($request->user_id);
            if ($user == null) {
                return $this->errorResponse("User doesn't exist", 404);
            }

            $task_comment->user_id = $request->user_id;
        }

        if ($request->has('task_id')) {
            $task = Task::find($request->task_id);
            if ($task == null) {
                return $this->errorResponse("Task doesn't exist", 404);
            }

            $task_comment->task_id = $request->task_id;
        }

        if ($request->has('comment')) {
            $task_comment->comment = $request->comment;
        }

        if (!$task_comment->isDirty()) {
            return $this->errorResponse('You need to specify a different value to update', 422);
        }

        $task_comment->save();
        return $this->getOne($task_comment);
    }
}
