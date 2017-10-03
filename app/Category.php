<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	protected $hidden = ['pivot'];
	
	/**
     * The courses that belong to the category
     */
    public function courses()
    {
        return $this->belongsToMany('App\User');
    }
}