<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
	protected $hidden = ['created_at', 'updated_at'];

    protected $appends = [
        'rating'
    ];

	/**
     * Get the user that belongs to instructor
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get all of the instructor's addresses
     */
    public function addresses()
    {
        return $this->morphMany('App\Address', 'addressable', NULL, 'addressable_id', 'user_id');
    }

    /**
     * Get the courses for the instructor
     */
    public function courses()
    {
        return $this->hasMany('App\Course', 'instructor', 'user_id');
    }

    /**
     * Get all of the instructor's ratings
     */
    public function ratings()
    {
        return $this->morphMany('App\Rating', 'rateable', NULL, 'rateable_id', 'user_id');
    }

    /**
     * The rating of the instructor
     */
    public function getRatingAttribute()
    {
        return 4.5;
    }
}
