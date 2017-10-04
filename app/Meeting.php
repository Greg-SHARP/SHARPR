<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{

    /**
     * The semester that belong to the meeting
     */
    public function semester()
    {
        return $this->hasOne('App\Semester');
    }
}
