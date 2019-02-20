<?php

namespace App\Http\Controllers;

use App\Helpers\LimitOffsetCriteria;
use App\Http\Repositories\VehicleRepository;
use App\Http\Response\APIResponse;
use Illuminate\Http\Request;
use App\Vehicle;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Vehicletype;


/**
 * Class VehicleController.
 *
 */
class VehicleController extends Controller
{
    protected $apiResponse;
    protected $vehicleRepository;
    public function __construct(APIResponse $apiResponse, VehicleRepository $vehicleRepository)
    {
        $this->apiResponse = $apiResponse;
        $this->vehicleRepository = $vehicleRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $vehicleCount = $this->vehicleRepository->countTotal();
        $this->vehicleRepository->pushCriteria(new RequestCriteria($request));
        $this->vehicleRepository->pushCriteria(new LimitOffsetCriteria($request));

        $vehicles = $this->vehicleRepository->with('vehicletype')->all();
        return $this->apiResponse->respondWithMessageAndPayload(['data'=>$vehicles,'total_count' => $vehicleCount],'Vehicles retrieved successfully.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        $vehicleTypes = Vehicletype::all()->pluck('type_name','id');
        return $this->apiResponse->respondWithMessageAndPayload($vehicleTypes,'Vehicle types retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param    \Illuminate\Http\Request  $request
     * @return  \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $vehicle = new Vehicle();
        $vehicle->vehicle_no = $request->vehicle_no;
        $vehicle->no_of_seats = $request->no_of_seats;
        $vehicle->max_allowed = $request->max_allowed;
        $vehicle->contact_person = $request->contact_person;
        $vehicle->insurance_renewal_date = $request->insurance_renewal_date;
        $vehicle->track_id = $request->track_id;
        $vehicle->vehicletype_id = $request->vehicletype_id;
        $vehicle->save();
        return $this->apiResponse->respondCreated('Vehicle added successfully.');

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
        $vehicle = Vehicle::with('vehicletype')->findOrfail($id);
        return $this->apiResponse->respondWithMessageAndPayload($vehicle,'Vehicle retrieved successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     * @param    \Illuminate\Http\Request  $request
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function edit($id,Request $request)
    {
        $vehicletypes = Vehicletype::all()->pluck('type_name','id');
        $vehicle = Vehicle::findOrfail($id);
        return $this->apiResponse->respondWithMessageAndPayload(['vehicle'=>$vehicle, 'vehicle_types'=>$vehicletypes],'Vehicle retrieved successfully.');
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
        $vehicle = Vehicle::findOrfail($id);
        $vehicle->vehicle_no = $request->vehicle_no;
        $vehicle->no_of_seats = $request->no_of_seats;
        $vehicle->max_allowed = $request->max_allowed;
        $vehicle->contact_person = $request->contact_person;
        $vehicle->insurance_renewal_date = $request->insurance_renewal_date;
        $vehicle->track_id = $request->track_id;
        $vehicle->vehicletype_id = $request->vehicletype_id;
        $vehicle->save();
        return $this->apiResponse->respondUpdated('Vehicle updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param    int $id
     * @return  \Illuminate\Http\Response
     */
    public function destroy($id)
    {
     	$vehicle = Vehicle::findOrfail($id);
     	$vehicle->delete();
        return $this->apiResponse->respondDeleted('Vehicle deleted successfully.');
    }
}
