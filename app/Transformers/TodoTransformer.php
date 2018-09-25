<?php

namespace App\Transformers;

use App\Todo;
use League\Fractal\TransformerAbstract;

/**
 * Class UserTransformer
 * @package App\Transformers
 */
class TodoTransformer extends TransformerAbstract
{
    /**
     * List of resources possible to embed via this processor
     *
     * @var array
     */
    protected $availableEmbeds = [
        'user',
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
            'name' => (string)$todo->name,
            'description' => (string)$todo->description,
            'creationDate' => (string)$todo->created_at,
            //HATEOAS
            'links' => [
                'rel' => 'self',
                'href' => route('users.todos.show', ['user' => $todo->user, 'todo' => $todo]),
                'tasks' => $todo->tasks_ids
            ],
        ];
    }

    /**
     * Embed User
     *
     * @return \League\Fractal\Resource\Item
     */
    public function embedUser(Todo $todo)
    {
        $user = $todo->user;
        return $this->item($user, new UserTransformer);
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
     *
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
}
