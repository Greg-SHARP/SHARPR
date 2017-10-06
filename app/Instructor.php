<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
	protected $hidden = ['created_at', 'updated_at'];

	/**
     * Get the user that is instructor
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get all of the instructor's ratings
     */
    public function ratings()
    {
        return $this->morphMany('App\Rating', 'rateable');
    }
}
