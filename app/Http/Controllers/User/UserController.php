<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\UserRequest;
use App\Transformers\UserTransformer;
use App\User;
use App\Http\Controllers\ApiController;

/**
 * Class UserController
 * @package App\Http\Controllers\User
 */
class UserController extends ApiController
{
    public function __construct()
    {
        $this->middleware('transform.input:' . UserTransformer::class)->only(['store', 'update']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $users = User::all();
        return $this->getAll($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\UserRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserRequest $request)
    {
        $data = $request->all();
        $data['password'] = bcrypt($request->password);
        $user = User::create($data);
        return $this->getOne($user, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(User $user)
    {
        return $this->getOne($user);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @throws \Exception
     * @param  User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $user)
    {
        $user->delete();
        return $this->getOne($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UserRequest $request, User $user)
    {
        $data = $request->all();
        $data['password'] = bcrypt($request->password);

        if (!$user->isDirty()) {
            return $this->errorResponse('You need to specify a different value to update', 422);
        }

        $user->fill($data);
        return $this->getOne($user);
    }
}
