<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    protected $hidden = ['created_at', 'updated_at'];

    /**
     * Get the user that belongs to institution
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get all of the institution's addresses
     */
    public function addresses()
    {
        return $this->morphMany('App\Address', 'addressable', NULL, 'addressable_id', 'user_id');
    }
}