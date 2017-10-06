<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
	protected $hidden = [
		'semester_id', 'pivot', 'created_at', 'updated_at'
	];

    /**
     * The semester that belong to the meeting
     */
    public function semester()
    {
        return $this->belongsTo('App\Semester');
    }
}
