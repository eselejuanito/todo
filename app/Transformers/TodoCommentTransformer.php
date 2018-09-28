<?php

namespace App\Transformers;

use App\TodoComment;
use League\Fractal\TransformerAbstract;

/**
 * Class TodoCommentTransformer
 * @package App\Transformers
 */
class TodoCommentTransformer extends TransformerAbstract
{
    /**
     * List of resources possible to embed via this processor
     *
     * @var array
     */
    protected $availableIncludes = [
        'user','todo'
    ];

    /**
     * To Fractal transformer.
     *
     * @param TodoComment $todo_comment
     *
     * @return array
     */
    public function transform(TodoComment $todo_comment)
    {
        return [
            'identifier' => (int)$todo_comment->id,
            'userId' => (int)$todo_comment->user_id,
            'userName' => $todo_comment->user()->first()->name,
            'todoId' => (int)$todo_comment->todo_id,
            'todoTitle' => $todo_comment->todo()->first()->title,
            'comment' => (string)$todo_comment->comment,
            'creationDate' => (string)$todo_comment->created_at,
            //HATEOAS
            'links' => [
                'rel' => 'self',
                'href' => route('comments.todos.show', $todo_comment->id),
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
            'userId' => 'user_id',
            'todoId' => 'todo_id',
            'comment' => 'comment',
            'creationDate' => 'created_at',
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
            'user_id' => 'userId',
            'todo_id' => 'todoId',
            'comment' => 'comment',
            'created_at' => 'creationDate',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    /**
     * Embed User
     *
     * @param TodoComment $todo_comment
     *
     * @return \League\Fractal\Resource\Item
     */
    public function includeUser(TodoComment $todo_comment)
    {
        $user = $todo_comment->user;
        return $this->item($user, new UserTransformer);
    }

    /**
     * Embed Todo
     *
     * @param TodoComment $todo_comment
     *
     * @return \League\Fractal\Resource\Item
     */
    public function includeTodo(TodoComment $todo_comment)
    {
        $todo = $todo_comment->todo;
        return $this->item($todo, new TodoTransformer);
    }
}
