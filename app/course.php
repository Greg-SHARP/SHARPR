<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
	protected $hidden = [
		'pivot', 'created_at', 'updated_at', 'group_id'
	];

    protected $appends = [
        'rating'
    ];

    /**
     * The instructor associated with the course
     */
    public function instructor()
    {
        return $this->hasOne('App\User', 'id', 'instructor');
    }

    /**
     * The group to course belongs to
     */
    public function group()
    {
        return $this->belongsTo('App\Group');
    }

    /**
     * The semesters that belong to the course
     */
    public function semesters()
    {
        return $this->hasMany('App\Semester');
    }

	/**
     * The categories that belong to the course
     */
    public function categories()
    {
        return $this->belongsToMany('App\Category');
    }

    /**
     * The tags that belong to the course
     */
    public function tags()
    {
        return $this->belongsToMany('App\Tag');
    }

    /**
     * Get all of the course's ratings
     */
    public function ratings()
    {
        return $this->morphMany('App\Rating', 'rateable');
    }

    /**
     * Get all of the course's likes
     */
    public function likes()
    {
        return $this->morphMany('App\Like', 'likeable');
    }

    /**
     * Get all of the course's dislikes
     */
    public function dislikes()
    {
        return $this->morphMany('App\Disike', 'dislikeable');
    }

    /**
     * The rating of the course
     */
    public function getRatingAttribute()
    {
        return $this->ratings()->avg('rating');
    }

    /**
     * The students that belong to the course
     */
    public function students()
    {
        return $this->belongsToMany('App\Course', 'course_user', 'course_id', 'user_id');
    }
}
