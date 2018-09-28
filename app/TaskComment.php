<?php

namespace App;

use App\Transformers\TaskCommentTransformer;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class TaskComment
 * @package App
 */
class TaskComment extends Model
{
    use SoftDeletes, SoftCascadeTrait;

    protected $table = 'task_comments';
    protected $dates = ['deleted_at'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'task_id', 'comment'
    ];

    public $transformer = TaskCommentTransformer::class;
    public $timestamps = true;

    /**-----------------------RELATIONSHIPS-----------------------**/

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function task()
    {
        return $this->belongsTo('App\Task');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
