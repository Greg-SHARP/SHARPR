<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
	protected $hidden = [
		'pivot', 'created_at', 'updated_at'
	];

    /**
     * The course that belong to the semester
     */
    public function courses()
    {
        return $this->hasOne('App\Semester');
    }

    /**
     * The meetings that belong to the semester
     */
    public function meetings()
    {
        return $this->hasMany('App\Meeting');
    }
}
