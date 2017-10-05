<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
	protected $hidden = [
		'pivot', 'created_at', 'updated_at'
	];

    protected $appends = [
        'duration', 'start_date', 'end_date'
    ];

    /**
     * The duration of the semester
     */
    public function getDurationAttribute()
    {
        return $this->meetings->count();
    }

    /**
     * The start date of the semester
     */
    public function getStartDateAttribute()
    {
        return $this->meetings->first()->start;
    }

    /**
     * The end date of the semester
     */
    public function getEndDateAttribute()
    {
        return $this->meetings->last()->end;
    }

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
