<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
	protected $hidden = ['pivot'];

    /**
     * Get instructor associated with the course
     */
    public function instructor()
    {
        return $this->hasOne('App\Instructor', 'user_id', 'instructor_id');
    }

	/**
     * The categories that belong to the course
     */
    public function categories()
    {
        return $this->belongsToMany('App\Category');
    }
}
