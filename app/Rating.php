<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
	protected $hidden = [
		'pivot', 'created_at', 'updated_at'
	];

    /**
     * The course associated with the rating
     */
    public function course()
    {
        return $this->hasOne('App\Course');
    }
}
