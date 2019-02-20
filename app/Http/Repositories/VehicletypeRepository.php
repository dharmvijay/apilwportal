<?php

namespace App\Http\Repositories;

use App\Test;
use App\Vehicle;
use App\Vehicletype;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;

class VehicletypeRepository extends BaseRepository
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
        return Vehicletype::class;
    }
    public function countTotal()
    {
        return Vehicletype::count();
    }
}
