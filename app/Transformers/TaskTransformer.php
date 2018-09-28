<?php

namespace App\Transformers;

use App\Task;
use League\Fractal\TransformerAbstract;

/**
 * Class TaskTransformer
 * @package App\Transformers
 */
class TaskTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'todo'
    ];

    /**
     * To Fractal transformer.
     *
     * @param Task $task
     *
     * @return array
     */
    public function transform(Task $task)
    {
        return [
            'identifier' => (int)$task->id,
            'title' => (string)$task->title,
            'description' => (string)$task->description,
            'status' => (string)$task->status,
            'creationDate' => (string)$task->created_at,
            //HATEOAS
            'links' => [
                'rel' => 'self',
                'href' => route('tasks.show', $task->id),
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
            'status' => 'status',
            'todoId' => 'todo_id',
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
            'status' => 'status',
            'todo_id' => 'todoId',
            'created_at' => 'creationDate',
            'updated_at' => 'lastChange',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    /**
     * Embed Todo
     *
     * @param Task $task
     *
     * @return \League\Fractal\Resource\Item
     */
    public function includeTodo(Task $task)
    {
        $todo = $task->todo;
        return $this->item($todo, new TodoTransformer);
    }
}
