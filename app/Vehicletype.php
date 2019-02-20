<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Vehicletype.
 *
 */
class Vehicletype extends Model
{
	
	use SoftDeletes;

	protected $dates = ['deleted_at'];
    
	
    protected $table = 'vehicletypes';

	
}
