<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Response;

class TestController extends Controller
{

    public function __construct()
    {
        $this->middleware('throttle:10');
    }

    public function __inboke()
    {
       

        // return 'Test';

        // $response = app()->make('response');
        // $response = app('response');
        //return response('test', 200, ['1'=>'2']);
        // $response = Response::make('gdfg');

        //return ['111'=>'222'];
        return response()->json(['11'=>'11'], 200, []);

        
    }
    
        
    
}

$this->TesController;
$TestController->bot();
