<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
	protected $hidden = [
		'pivot', 'created_at', 'updated_at'
	];

    /**
     * The courses that belong to the tag
     */
    public function courses()
    {
        return $this->belongsToMany('App\Course');
    }

    /**
     * Get all of the tag's likes
     */
    public function likes()
    {
        return $this->morphMany('App\Like', 'likeable');
    }

    /**
     * Get all of the tag's dislikes
     */
    public function dislikes()
    {
        return $this->morphMany('App\Dislike', 'dislikeable');
    }
}