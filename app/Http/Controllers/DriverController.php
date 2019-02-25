<?php

namespace App\Http\Controllers;

use App\Helpers\LimitOffsetCriteria;
use App\Http\Repositories\DriverRepository;
use App\Http\Response\APIResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use App\Driver;
use Prettus\Repository\Criteria\RequestCriteria;
use URL;

use App\Vehicle;


/**
 * Class DriverController.
 *
 * @author  The scaffold-interface created at 2019-02-22 07:47:44am
 * @link  https://github.com/amranidev/scaffold-interface
 */
class DriverController extends Controller
{
    protected $apiResponse;
    protected $driverRepository;
    public function __construct(APIResponse $apiResponse, DriverRepository $driverRepository)
    {
        $this->apiResponse = $apiResponse;
        $this->driverRepository = $driverRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $driverCount = $this->driverRepository->countTotal();
        $this->driverRepository->pushCriteria(new RequestCriteria($request));
        $this->driverRepository->pushCriteria(new LimitOffsetCriteria($request));

        $driver = $this->driverRepository->with('vehicle')->all();
        return $this->apiResponse->respondWithMessageAndPayload(['data'=>$driver,'total_count' => $driverCount],
            'Drivers retrieved successfully.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        $vehicle = Vehicle::all()->pluck('vehicle_no','id');
        return $this->apiResponse->respondWithMessageAndPayload($vehicle,'Vehicle retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param    \Illuminate\Http\Request  $request
     * @return  \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $driver = new Driver();
        $driver->name = $request->name;
        $driver->present_address = $request->present_address;
        $driver->permanent_address = $request->permanent_address;
        $driver->date_of_birth = $request->date_of_birth;
        $driver->phone = $request->phone;
        $driver->license_number = $request->license_number;
        $driver->vehicle_id = $request->vehicle_id;
        $driver->save();
        return $this->apiResponse->respondCreated('Driver added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param    \Illuminate\Http\Request  $request
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function show($id,Request $request)
    {
        $driver = Driver::with('vehicle')->findOrfail($id);
        return $this->apiResponse->respondWithMessageAndPayload($driver,'Driver retrieved successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     * @param    \Illuminate\Http\Request  $request
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function edit($id,Request $request)
    {
        $vehicle = Vehicle::all()->pluck('vehicle_no','id');
        $driver = Driver::findOrfail($id);
        return $this->apiResponse->respondWithMessageAndPayload(['driver'=>$driver, 'vehicle_no'=>$vehicle
        ],'Driver retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param    \Illuminate\Http\Request  $request
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function update($id,Request $request)
    {
        $driver = Driver::findOrfail($id);
        $driver->name = $request->name;
        $driver->present_address = $request->present_address;
        $driver->permanent_address = $request->permanent_address;
        $driver->date_of_birth = $request->date_of_birth;
        $driver->phone = $request->phone;
        $driver->license_number = $request->license_number;
        $driver->vehicle_id = $request->vehicle_id;
        $driver->save();
        return $this->apiResponse->respondUpdated('Driver updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param    int $id
     * @return  \Illuminate\Http\Response
     */
    public function destroy($id)
    {
     	$driver = Driver::findOrfail($id);
     	$driver->delete();
        return $this->apiResponse->respondDeleted('Driver deleted successfully.');
    }
}
