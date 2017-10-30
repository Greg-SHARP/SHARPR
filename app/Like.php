<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
	protected $fillable = ['user_id', 'likeable_id', 'likeable_type'];
	protected $hidden = ['created_at', 'updated_at'];

    /**
     * Get all of the owning likeable models
     */
    public function likeable()
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