<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
	/**
     * Get the user that belongs to institution
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}