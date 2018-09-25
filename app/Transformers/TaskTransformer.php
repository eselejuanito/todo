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
            'name' => (string)$task->name,
            'description' => (string)$task->description,
            'creationDate' => (string)$task->created_at,
            //HATEOAS
            'links' => [
                'rel' => 'self',
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
            'name' => 'name',
            'description' => 'description',
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
            'name' => 'name',
            'description' => 'description',
            'created_at' => 'creationDate',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
