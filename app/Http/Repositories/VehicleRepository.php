<?php

namespace App\Http\Repositories;

use App\Test;
use App\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;

class VehicleRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Vehicle::class;
    }
    public function countTotal()
    {
        return Vehicle::count();
    }
}
