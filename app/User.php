<?php

namespace App;

use App\Transformers\UserTransformer;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 * @package App
 */
class User extends Authenticatable
{
    use Notifiable, SoftDeletes, SoftCascadeTrait;

    protected $softCascade = ['todos','todoComments','tasksAssigned'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = ['todos_ids'];

    public $transformer = UserTransformer::class;

    /**-----------------------RELATIONSHIPS-----------------------**/

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function todos()
    {
        return $this->hasMany('App\Todo');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function todoComments()
    {
        return $this->hasMany('App\TodoComment');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasksAssigned()
    {
        return $this->hasMany('App\TaskAssigned');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function todosComments()
    {
        return $this->hasMany('App\TodoComment');
    }

    /**-----------------------QUERIES-----------------------**/

    /**
     * @return mixed
     */
    public function getTodosIdsAttribute()
    {
        return $this->todos->pluck('id');
    }

    /**
     * @return mixed
     */
    public function tasks()
    {
        return Task::whereHas('todo', function ($query) {
            $query->where('user_id', $this->id);
        })->get();
    }

    /**
     * @return mixed
     */
    public function taskComments()
    {
        return TaskComment::whereHas('user', function ($query) {
            $query->where('user_id', $this->id);
        })->get();
    }
}
