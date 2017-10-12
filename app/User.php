<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

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
        'password', 'remember_token', 'created_at', 'updated_at'
    ];

    /**
     * The instructor associated with the user
     */
    public function instructor()
    {
        return $this->hasOne('App\Instructor');
    }

    /**
     * The student associated with the user
     */
    public function student()
    {
        return $this->hasOne('App\Student');
    }

    /**
     * Get the roles for the user
     */
    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }
}
