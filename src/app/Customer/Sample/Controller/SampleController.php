<?php
namespace App\Customer\Sample\Controller;

use App\Common\Sample\Contract\SampleRepository as SampleRepositoryContract;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;
use App\Common\Http\Controller\AbsController;

/**
 * ホーム画面に関連する処理を行うクラス。
 * @package \App\Customer\Home
 */
class SampleController extends AbsController
{
    private SampleRepositoryContract $sampleRepository;

    /**
     * constructor.
     */
    public function __construct(SampleRepositoryContract $sampleRepository)
    {
        $this->sampleRepository = $sampleRepository;
    }
    /**
     * ホーム画面を表示する。
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $sample = $this->sampleRepository->fetchAll([]);
        dd($sample);
        $names = explode('.', Route::current()->getName());
        return view('sample.page'.Arr::last($names));
    }
}
