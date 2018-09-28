<?php

namespace App\Transformers;

use App\User;
use League\Fractal\TransformerAbstract;

/**
 * Class UserTransformer
 * @package App\Transformers
 */
class UserTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'todos', 'tasks', 'todoComments', 'taskComments', 'tasksAssigned'
    ];

    /**
     * To Fractal transformer.
     * @param \App\User
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'identifier' => (int)$user->id,
            'name' => (string)$user->name,
            'email' => (string)$user->email,
            'creationDate' => (string)$user->created_at,
            'lastChange' => (string)$user->updated_at,
            //HATEOAS
            'links' => [
                'rel' => 'self',
                'href' => route('users.show', $user->id),
                'todos' => $user->todos_ids
            ],
        ];
    }

    /**
     * To get real attribute
     * @param User
     * @return array
     */
    public static function originalAttribute($index)
    {
        $attributes = [
            'identifier' => 'id',
            'name' => 'name',
            'email' => 'email',
            'password' => 'password',
            'creationDate' => 'created_at',
            'lastChange' => 'updated_at',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }


    /**
     * To post transformed attributes
     * @param User
     * @return array
     */
    public static function transformedAttribute($index)
    {
        $attributes = [
            'id' => 'identifier',
            'name' => 'name',
            'email' => 'email',
            'password' => 'password',
            'created_at' => 'creationDate',
            'updated_at' => 'lastChange',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    /**
     * Embed Todos
     *
     * @param User $user
     *
     * @return \League\Fractal\Resource\Collection
     */
    public function includeTodos(User $user)
    {
        $todos = $user->todos;
        return $this->collection($todos, new TodoTransformer);
    }

    /**
     * Embed Tasks
     *
     * @param User $user
     *
     * @return \League\Fractal\Resource\Collection
     */
    public function includeTasks(User $user)
    {
        $tasks = $user->tasks();
        return $this->collection($tasks, new TaskTransformer);
    }

    /**
     * Embed Tasks
     *
     * @param User $user
     *
     * @return \League\Fractal\Resource\Collection
     */
    public function includeTodoComments(User $user)
    {
        $todo_comments = $user->todoComments()->get();
        return $this->collection($todo_comments, new TodoCommentTransformer);
    }

    /**
     * Embed Tasks
     *
     * @param User $user
     *
     * @return \League\Fractal\Resource\Collection
     */
    public function includeTaskComments(User $user)
    {
        $task_comments = $user->taskComments();
        return $this->collection($task_comments, new TaskCommentTransformer);
    }

    /**
     * Embed Tasks Assigned
     *
     * @param User $user
     *
     * @return \League\Fractal\Resource\Collection
     */
    public function includeTasksAssigned(User $user)
    {
        $tasks_assigned = $user->tasksAssigned()->get();
        return $this->collection($tasks_assigned, new TaskAssignTransformer);
    }
}
