<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
	protected $hidden = ['created_at', 'updated_at'];

	/**
     * Get the user that belongs to instructor
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

    /**
     * Get all of the instructor's addresses
     */
    public function addresses()
    {
        return $this->morphMany('App\Address', 'addressable', NULL, 'addressable_id', 'user_id');
    }
}
