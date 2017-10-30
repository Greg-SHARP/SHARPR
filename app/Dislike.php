<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dislike extends Model
{
	protected $fillable = ['user_id', 'dislikeable_id', 'dislikeable_type'];

    /**
     * Get all of the owning likeable models
     */
    public function dislikeable()
    {
        return $this->morphTo();
    }
}