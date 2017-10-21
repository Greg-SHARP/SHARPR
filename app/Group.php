<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $hidden = ['created_at', 'updated_at'];

	/**
     * The courses the group has
     */
    public function courses()
    {
        return $this->hasMany('App\Course');
    }
}
