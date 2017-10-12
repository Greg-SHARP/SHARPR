<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
	protected $hidden = [
		'pivot', 'created_at', 'updated_at'
	];
    
    /**
     * Get the users for the role
     */
    public function users()
    {
        return $this->belongsToMany('App\User');
    }
}
