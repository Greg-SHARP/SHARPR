<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
	protected $hidden = [
		'user_id', 'rateable_id', 'rateable_type', 'pivot'
	];

    /**
     * Get all of the owning rateable models
     */
    public function rateable()
    {
        return $this->morphTo();
    }

    /**
     * The user associate with the rating
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
