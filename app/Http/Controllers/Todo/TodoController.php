<?php

namespace App\Http\Controllers\Todo;

use App\Http\Requests\TodoRequest;
use App\Transformers\TodoTransformer;
use App\Todo;
use App\Http\Controllers\ApiController;
use App\User;

/**
 * Class TodoController
 * @package App\Http\Controllers\Todo
 */
class TodoController extends ApiController
{
    public function __construct()
    {
        $this->middleware('transform.input:' . TodoTransformer::class)->only(['store', 'update']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $todos = Todo::all();
        return $this->getAll($todos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\TodoRequest
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(TodoRequest $request)
    {
        $data = $request->all();
        $user = User::find($data['user_id']);
        if ($user == null) {
            return $this->errorResponse("User doesn't exist", 404);
        }

        $todo = Todo::create($data);
        return $this->getOne($todo, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Todo $todo
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Todo $todo)
    {
        return $this->getOne($todo);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  Todo $todo
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Todo $todo)
    {
        $todo->delete();
        return $this->getOne($todo);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\TodoRequest  $request
     * @param  Todo $todo
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(TodoRequest $request, Todo $todo)
    {
        if ($request->has('user_id')) {
            $user = User::find($request->user_id);
            if ($user == null) {
                return $this->errorResponse("User doesn't exist", 404);
            }

            $todo->user_id = $request->user_id;
        }

        if ($request->has('title')) {
            $todo->title = $request->title;
        }

        if ($request->has('description')) {
            $todo->description = $request->description;
        }

        if ($request->has('target_date')) {
            $todo->target_date = $request->target_date;
        }

        if (!$todo->isDirty()) {
            return $this->errorResponse('You need to specify a different value to update', 422);
        }

        $todo->save();
        return $this->getOne($todo);
    }
}
