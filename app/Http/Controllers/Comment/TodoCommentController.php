<?php

namespace App\Http\Controllers\Comment;

use App\Http\Requests\TodoCommentRequest;
use App\Todo;
use App\Transformers\TodoCommentTransformer;
use App\TodoComment;
use App\Http\Controllers\ApiController;
use App\User;

/**
 * Class TodoCommentController
 * @package App\Http\Controllers\Comment
 */
class TodoCommentController extends ApiController
{
    public function __construct()
    {
        $this->middleware('transform.input:' . TodoCommentTransformer::class)->only(['store', 'update']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $todo_comments = TodoComment::all();
        return $this->getAll($todo_comments);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\TodoCommentRequest
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(TodoCommentRequest $request)
    {
        $data = $request->all();
        $user = User::find($data['user_id']);
        if ($user == null) {
            return $this->errorResponse("User doesn't exist", 404);
        }

        $todo = Todo::find($data['todo_id']);
        if ($todo == null) {
            return $this->errorResponse("Todo doesn't exist", 404);
        }

        $todo_comment = TodoComment::create($data);
        return $this->getOne($todo_comment, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param TodoComment $todo_comment
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($todo_comment)
    {
        $todo_comment = TodoComment::find($todo_comment);
        if ($todo_comment == null) {
            return $this->errorResponse("Comment doesn't exist", 404);
        }
        return $this->getOne($todo_comment);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  TodoComment $todo_comment
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy($todo_comment)
    {
        $todo_comment = TodoComment::find($todo_comment);
        if ($todo_comment == null) {
            return $this->errorResponse("Comment doesn't exist", 404);
        }

        $todo_comment->delete();
        return $this->getOne($todo_comment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\TodoCommentRequest $request
     * @param  TodoComment $todo_comment
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(TodoCommentRequest $request, $todo_comment)
    {
        $todo_comment = TodoComment::find($todo_comment);
        if ($todo_comment == null) {
            return $this->errorResponse("Comment doesn't exist", 404);
        }

        if ($request->has('user_id')) {
            $user = User::find($request->user_id);
            if ($user == null) {
                return $this->errorResponse("User doesn't exist", 404);
            }

            $todo_comment->user_id = $request->user_id;
        }

        if ($request->has('todo_id')) {
            $todo = Todo::find($request->todo_id);
            if ($todo == null) {
                return $this->errorResponse("Todo doesn't exist", 404);
            }

            $todo_comment->todo_id = $request->todo_id;
        }

        if ($request->has('comment')) {
            $todo_comment->comment = $request->comment;
        }

        if (!$todo_comment->isDirty()) {
            return $this->errorResponse('You need to specify a different value to update', 422);
        }

        $todo_comment->save();
        return $this->getOne($todo_comment);
    }
}
