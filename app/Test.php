<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Test.
 *
 * @author  The scaffold-interface created at 2019-02-16 07:27:40pm
 * @link  https://github.com/amranidev/scaffold-interface
 */
class Test extends Model
{
	
	use SoftDeletes;

	protected $dates = ['deleted_at'];
    
	
    protected $table = 'tests';

	
	public function task()
	{
		return $this->belongsTo('App\Task','task_id');
	}

	
}
