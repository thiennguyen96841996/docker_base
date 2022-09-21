<?php
namespace GLC\Client\Http\Controllers;

use Illuminate\Contracts\View\View;
use GLC\Client\Http\Controllers\AbsBaseController as BaseController;

/**
 * Laravel test
 *
 **/
class TestController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Laravel function
     *
     **/
    public function clientIndex()
    {
        return view('client_test');
    }
}