<?php

namespace App\Transformers;

use App\TaskAssigned;
use League\Fractal\TransformerAbstract;

/**
 * Class TaskAssignTransformer
 * @package App\Transformers
 */
class TaskAssignTransformer extends TransformerAbstract
{
    /**
     * List of resources possible to embed via this processor
     *
     * @var array
     */
    protected $availableIncludes = [
        'user','task'
    ];

    /**
     * To Fractal transformer.
     *
     * @param TaskAssigned $task_assigned
     *
     * @return array
     */
    public function transform(TaskAssigned $task_assigned)
    {
        return [
            'userId' => (int)$task_assigned->user_id,
            'userName' => $task_assigned->user()->first()->name,
            'taskId' => (int)$task_assigned->task_id,
            'taskTitle' => $task_assigned->task()->first()->title,
            'creationDate' => (string)$task_assigned->created_at,
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
            'userId' => 'user_id',
            'taskId' => 'task_id',
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
            'user_id' => 'userId',
            'task_id' => 'taskId',
            'created_at' => 'creationDate',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    /**
     * Embed User
     *
     * @param TaskAssigned $task_assigned
     *
     * @return \League\Fractal\Resource\Item
     */
    public function includeUser(TaskAssigned $task_assigned)
    {
        $user = $task_assigned->user;
        return $this->item($user, new UserTransformer);
    }

    /**
     * Embed Task
     *
     * @param TaskAssigned $task_assigned
     *
     * @return \League\Fractal\Resource\Item
     */
    public function includeTask(TaskAssigned $task_assigned)
    {
        $task = $task_assigned->task;
        return $this->item($task, new TaskTransformer);
    }
}
