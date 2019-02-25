<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Driver.
 *
 * @author  The scaffold-interface created at 2019-02-22 07:47:42am
 * @link  https://github.com/amranidev/scaffold-interface
 */
class Driver extends Model
{
	
	use SoftDeletes;

	protected $dates = ['deleted_at'];
    
	
    protected $table = 'drivers';

	
	public function vehicle()
	{
		return $this->belongsTo('App\Vehicle','vehicle_id');
	}

	
}
