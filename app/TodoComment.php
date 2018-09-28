<?php

namespace App;

use App\Transformers\TodoCommentTransformer;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class TodoComment
 * @package App
 */
class TodoComment extends Model
{
    use SoftDeletes, SoftCascadeTrait;

    protected $table = 'todo_comments';
    protected $dates = ['deleted_at'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'todo_id', 'comment'
    ];

    public $transformer = TodoCommentTransformer::class;
    public $timestamps = true;

    /**-----------------------RELATIONSHIPS-----------------------**/

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function todo()
    {
        return $this->belongsTo('App\Todo');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
