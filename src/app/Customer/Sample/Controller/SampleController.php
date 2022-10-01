<?php
namespace App\Customer\Sample\Controller;

use App\Common\Sample\Service\SampleService;
use Illuminate\Http\JsonResponse;
use App\Common\Http\Controller\AbsController;
use Illuminate\Support\Facades\Log;
use Throwable;

/**
 * ホーム画面に関連する処理を行うクラス。
 * @package \App\Customer\Home
 */
class SampleController extends AbsController
{
    private SampleService $sampleService;

    /**
     * constructor.
     */
    public function __construct(SampleService $sampleService)
    {
        $this->sampleService = $sampleService;
    }
    /**
     * ホーム画面を表示する。
     * @return \Illuminate\View\View
     */
    public function index(): JsonResponse
    {
        //sample for Vue FE
        try{
            $sample = $this->sampleService->getViewModel(['id' => '10001']);

            return response()->json(['sample' => $sample]);
        } catch (Throwable $thw) {
            Log::channel('error')->error($thw);

            return response()->json([], 500);
        }
    }
}
