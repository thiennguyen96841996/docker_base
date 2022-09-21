<?php
namespace GLC\Master\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;

/**
 * Laravel test
 *
 **/
class TestController extends BaseController
{
    /**
     * Laravel function
     *
     **/
    public function customerIndex(){
        return view('customer_test');
    }

    public function toolIndex(){
        return view('tool_test');
    }

    public function clientIndex(){
        return view('client_test');
    }
}