<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
	protected $hidden = [
		'rateable_id', 'rateable_type', 'pivot', 'created_at', 'updated_at'
	];

    /**
     * Get all of the owning rateable models
     */
    public function rateable()
    {
        return $this->morphTo();
    }
}
