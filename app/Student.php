<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $hidden = ['created_at', 'updated_at'];

    /**
     * Get the user that belongs to student
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    /**
     * Get all of the student's addresses
     */
    public function addresses()
    {
        return $this->morphMany('App\Address', 'addressable', NULL, 'addressable_id', 'user_id');
    }

    /**
     * The courses that belong to the student
     */
    public function courses()
    {
        return $this->belongsToMany('App\Course', 'course_user', 'course_id', 'user_id');
    }
}
