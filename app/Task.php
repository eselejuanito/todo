<?php

namespace App;

use App\Transformers\TaskTransformer;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Task
 * @package App
 */
class Task extends Model
{
    use SoftDeletes, SoftCascadeTrait;

    protected $softCascade = ['todoComments','tasksAssigned'];

    // Kind of status for a task
    const STATUS = ['pending', 'completed'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'status', 'todo_id'
    ];

    public $transformer = TaskTransformer::class;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function todo()
    {
        return $this->belongsTo('App\Todo');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function taskComments()
    {
        return $this->hasMany('App\TaskComment');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasksAssigned()
    {
        return $this->hasMany('App\TaskAssigned');
    }
}
