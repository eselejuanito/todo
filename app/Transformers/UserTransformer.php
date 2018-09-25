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
        'todos',
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
}
