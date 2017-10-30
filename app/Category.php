<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{	
	protected $hidden = [
		'pivot', 'created_at', 'updated_at'
	];

	/**
     * The courses that belong to the category
     */
    public function courses()
    {
        return $this->belongsToMany('App\User');
    }

    /**
     * Get all of the category's likes
     */
    public function likes()
    {
        return $this->morphMany('App\Like', 'likeable');
    }

    /**
     * Get all of the category's dislikes
     */
    public function dislikes()
    {
        return $this->morphMany('App\Dislike', 'dislikeable');
    }
}