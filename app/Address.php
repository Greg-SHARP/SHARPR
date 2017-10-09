<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
	protected $hidden = [
		'id', 'addressable_id', 'addressable_type', 'pivot', 'created_at', 'updated_at'
	];

    /**
     * Get all of the owning addressable models
     */
    public function addressable()
    {
        return $this->morphTo();
    }
}
