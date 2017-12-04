<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
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
     * The institution associated with the user
     */
    public function institution()
    {
        return $this->hasOne('App\Institution');
    }

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

    /**
     * The likes that belong to the user
     */
    public function likes()
    {
        return $this->hasMany('App\Like');
    }

    /**
     * The dislikes that belong to the user
     */
    public function dislikes()
    {
        return $this->hasMany('App\Dislike');
    }
    
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
