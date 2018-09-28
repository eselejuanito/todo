<?php

namespace App;

use App\Transformers\TaskAssignTransformer;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class TaskAssigned
 * @package App
 */
class TaskAssigned extends Model
{
    use SoftDeletes, SoftCascadeTrait;

    protected $table = 'task_assigned';
    protected $dates = ['deleted_at'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'task_id'
    ];

    public $transformer = TaskAssignTransformer::class;
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
