<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dislike extends Model
{
	protected $fillable = ['user_id', 'dislikeable_id', 'dislikeable_type'];
	protected $hidden = ['created_at', 'updated_at'];

    /**
     * Get all of the owning likeable models
     */
    public function dislikeable()
    {
        return $this->morphTo();
    }

    /**
     * The user associate with the likes
     */
    public function user()
    {
        return $this->hasOne('App\User');
    }
}