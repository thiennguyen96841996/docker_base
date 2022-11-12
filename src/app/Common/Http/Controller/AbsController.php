<?php
namespace App\Common\Http\Controller;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * すべてのコントローラーの継承元となるクラス。
 * @package \App\Common\Http
 */
abstract class AbsController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
