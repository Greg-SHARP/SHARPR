<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
	protected $hidden = [
		'course_id', 'pivot', 'created_at', 'updated_at'
	];

    protected $appends = [
        'duration', 'start_date', 'end_date'
    ];
    
    protected $guarded = [];

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
    public function course()
    {
        return $this->belongsTo('App\Course');
    }

    /**
     * The meetings that belong to the semester
     */
    public function meetings()
    {
        return $this->hasMany('App\Meeting');
    }

    /**
     * Get all of the semester's addresses
     */
    public function addresses()
    {
        return $this->morphMany('App\Address', 'addressable');
    }
}
