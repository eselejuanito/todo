<?php

namespace App\Transformers;

use App\TaskComment;
use League\Fractal\TransformerAbstract;

/**
 * Class TaskCommentTransformer
 * @package App\Transformers
 */
class TaskCommentTransformer extends TransformerAbstract
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
     * @param TaskComment $task_comment
     *
     * @return array
     */
    public function transform(TaskComment $task_comment)
    {
        return [
            'identifier' => (int)$task_comment->id,
            'userId' => (int)$task_comment->user_id,
            'userName' => $task_comment->user()->first()->name,
            'taskId' => (int)$task_comment->task_id,
            'taskTitle' => $task_comment->task()->first()->title,
            'comment' => (string)$task_comment->comment,
            'creationDate' => (string)$task_comment->created_at,
            //HATEOAS
            'links' => [
                'rel' => 'self',
                'href' => route('comments.tasks.show', $task_comment->id),
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
            'taskId' => 'task_id',
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
            'task_id' => 'taskId',
            'comment' => 'comment',
            'created_at' => 'creationDate',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    /**
     * Embed User
     *
     * @param TaskComment $task_comment
     *
     * @return \League\Fractal\Resource\Item
     */
    public function includeUser(TaskComment $task_comment)
    {
        $user = $task_comment->user;
        return $this->item($user, new UserTransformer);
    }

    /**
     * Embed Task
     *
     * @param TaskComment $task_comment
     *
     * @return \League\Fractal\Resource\Item
     */
    public function includeTask(TaskComment $task_comment)
    {
        $task = $task_comment->task;
        return $this->item($task, new TaskTransformer);
    }
}
