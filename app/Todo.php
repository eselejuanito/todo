<?php

namespace App;

use App\Transformers\TodoTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;

/**
 * Class Todo
 * @package App
 */
class Todo extends Model
{
    use SoftDeletes, SoftCascadeTrait;

    protected $softCascade = ['tasks'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'target_date', 'user_id'
    ];

    protected $appends = ['tasks_ids'];

    public $transformer = TodoTransformer::class;
    public $timestamps = true;

    /**-----------------------RELATIONSHIPS-----------------------**/

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasks()
    {
        return $this->hasMany('App\Task');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**-----------------------QUERIES-----------------------**/

    /**
     * @return mixed
     */
    public function getTasksIdsAttribute()
    {
        return $this->tasks->pluck('id');
    }
}
