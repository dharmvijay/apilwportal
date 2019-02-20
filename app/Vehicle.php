<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Vehicle.
 *
 */
class Vehicle extends Model
{
	
	use SoftDeletes;

	protected $dates = ['deleted_at'];
    
	
    protected $table = 'vehicles';

	
	public function vehicletype()
	{
		return $this->belongsTo('App\Vehicletype','vehicletype_id');
	}

	
}
