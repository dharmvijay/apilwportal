<?php

namespace App\Http\Controllers;

use App\Helpers\LimitOffsetCriteria;
use App\Http\Repositories\VehicletypeRepository;
use App\Http\Response\APIResponse;
use Illuminate\Http\Request;
use App\Vehicletype;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class VehicletypeController.
 *
 */
class VehicletypeController extends Controller
{


    protected $apiResponse;
    protected $vehicletypeRepository;
    public function __construct(APIResponse $apiResponse, VehicletypeRepository $vehicletypeRepository)
    {
        $this->apiResponse = $apiResponse;
        $this->vehicletypeRepository = $vehicletypeRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $vehicleCount = $this->vehicletypeRepository->countTotal();
        $this->vehicletypeRepository->pushCriteria(new RequestCriteria($request));
        $this->vehicletypeRepository->pushCriteria(new LimitOffsetCriteria($request));
        $vehicles = $this->vehicletypeRepository->all();
        return $this->apiResponse->respondWithMessageAndPayload(['data'=>$vehicles,'total_count' => $vehicleCount],'Vehicle types retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param    \Illuminate\Http\Request  $request
     * @return  \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $vehicletype = new Vehicletype();
        $vehicletype->type_name = $request->type_name;
        $vehicletype->save();
        return $this->apiResponse->respondCreated('Vehicle type added successfully.');

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
        $vehicletype = Vehicletype::findOrfail($id);
        return $this->apiResponse->respondWithMessageAndPayload($vehicletype,'Vehicle retrieved successfully.');
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
        $vehicletype = Vehicletype::findOrfail($id);
        $vehicletype->type_name = $request->type_name;
        $vehicletype->save();
        return $this->apiResponse->respondUpdated('Vehicle type updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param    int $id
     * @return  \Illuminate\Http\Response
     */
    public function destroy($id)
    {
     	$vehicletype = Vehicletype::findOrfail($id);
     	$vehicletype->delete();
        return $this->apiResponse->respondDeleted('Vehicle deleted successfully.');
    }
}
