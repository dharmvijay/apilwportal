<?php

namespace App\Http\Controllers;

use App\Http\Repositories\TestRepository;
use App\Http\Response\APIResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use App\Test;
use App\Helpers\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;



/**
 * Class TestController.
 *
 * @author  The scaffold-interface created at 2019-02-16 07:27:41pm
 * @link  https://github.com/amranidev/scaffold-interface
 */
class TestController extends Controller
{
    protected $apiResponse;
    protected $testRepository;
    public function __construct(APIResponse $apiResponse, TestRepository $testRepository)
    {
        $this->apiResponse = $apiResponse;
        $this->testRepository = $testRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $testsCount = $this->testRepository->countTotal();
        $this->testRepository->pushCriteria(new RequestCriteria($request));
        $this->testRepository->pushCriteria(new LimitOffsetCriteria($request));

        $tests = $this->testRepository->all();
        return $this->apiResponse->respondWithMessageAndPayload(['data'=>$tests,'total_count' => $testsCount],'Test retrived successfully.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Create - test';
        
        $tasks = Task::all()->pluck('title','id');
        
        return view('test.create',compact('title','tasks'  ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param    \Illuminate\Http\Request  $request
     * @return  \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $test = new Test();

        
        $test->name = $request->name;

        
        
        $test->task_id = $request->task_id;

        
        $test->save();

        $pusher = App::make('pusher');

        //default pusher notification.
        //by default channel=test-channel,event=test-event
        //Here is a pusher notification example when you create a new resource in storage.
        //you can modify anything you want or use it wherever.
        $pusher->trigger('test-channel',
                         'test-event',
                        ['message' => 'A new test has been created !!']);

        return redirect('test');
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
        $title = 'Show - test';

        if($request->ajax())
        {
            return URL::to('test/'.$id);
        }

        $test = Test::findOrfail($id);
        return view('test.show',compact('title','test'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param    \Illuminate\Http\Request  $request
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function edit($id,Request $request)
    {
        $title = 'Edit - test';
        if($request->ajax())
        {
            return URL::to('test/'. $id . '/edit');
        }

        
        $tasks = Task::all()->pluck('title','id');

        
        $test = Test::findOrfail($id);
        return view('test.edit',compact('title','test' ,'tasks' ) );
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
        $test = Test::findOrfail($id);
    	
        $test->name = $request->name;
        
        
        $test->task_id = $request->task_id;

        
        $test->save();

        return redirect('test');
    }

    /**
     * Delete confirmation message by Ajaxis.
     *
     * @link      https://github.com/amranidev/ajaxis
     * @param    \Illuminate\Http\Request  $request
     * @return  String
     */
    public function DeleteMsg($id,Request $request)
    {
        $msg = Ajaxis::BtDeleting('Warning!!','Would you like to remove This?','/test/'. $id . '/delete');

        if($request->ajax())
        {
            return $msg;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param    int $id
     * @return  \Illuminate\Http\Response
     */
    public function destroy($id)
    {
     	$test = Test::findOrfail($id);
     	$test->delete();
        return URL::to('test');
    }
}
