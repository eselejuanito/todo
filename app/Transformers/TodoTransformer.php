<?php

namespace App\Transformers;

use App\Todo;
use League\Fractal\TransformerAbstract;

/**
 * Class TodoTransformer
 * @package App\Transformers
 */
class TodoTransformer extends TransformerAbstract
{
    /**
     * List of resources possible to embed via this processor
     *
     * @var array
     */
    protected $availableIncludes = [
        'user','tasks'
    ];

    /**
     * To Fractal transformer.
     *
     * @param Todo $todo
     *
     * @return array
     */
    public function transform(Todo $todo)
    {
        return [
            'identifier' => (int)$todo->id,
            'title' => (string)$todo->title,
            'description' => (string)$todo->description,
            'targetDate' => (string)$todo->target_date,
            'creationDate' => (string)$todo->created_at,
            //HATEOAS
            'links' => [
                'rel' => 'self',
                'href' => route('todos.show', $todo->id),
                'tasks' => $todo->tasks_ids
            ],
        ];
    }

    /**
     * To get real attribute
     *
     * @return array
     */
    public static function originalAttribute($index)
    {
        $attributes = [
            'identifier' => 'id',
            'title' => 'title',
            'description' => 'description',
            'userId' => 'user_id',
            'creationDate' => 'created_at',
            'lastChange' => 'updated_at',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }


    /**
     * To post transformed attributes
     *
     * @return array
     */
    public static function transformedAttribute($index)
    {
        $attributes = [
            'id' => 'identifier',
            'title' => 'title',
            'description' => 'description',
            'user_id' => 'userId',
            'created_at' => 'creationDate',
            'updated_at' => 'lastChange',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    /**
     * Embed User
     *
     * @param Todo $todo
     *
     * @return \League\Fractal\Resource\Item
     */
    public function includeUser(Todo $todo)
    {
        $user = $todo->user;
        return $this->item($user, new UserTransformer);
    }

    /**
     * Embed Tasks
     *
     * @param Todo $todo
     *
     * @return \League\Fractal\Resource\Collection
     */
    public function includeTasks(Todo $todo)
    {
        $tasks = $todo->tasks;
        return $this->collection($tasks, new TaskTransformer);
    }
}
