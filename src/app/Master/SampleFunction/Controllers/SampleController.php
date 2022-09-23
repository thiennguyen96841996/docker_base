<?php
namespace GLC\Master\SampleFunction\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;
use Illuminate\Contracts\View\View;
use GLC\Master\Http\Controllers\AbsBaseController as BaseController;
use GLC\Platform\Sample\Contracts\SampleRepositoryContract;
//use Illuminate\Http\Request;

use Illuminate\Support\MessageBag;
use GLC\Master\SampleFunction\Forms\SampleSearchRequest;
use GLC\Master\SampleFunction\Forms\SampleStoreRequest;


class SampleController extends BaseController
{

//    private $repo;
//
//    public function __construct(SampleRepositoryContract $repo)
//    {
//        $this->repo = $repo;
//        parent::__construct();
//    }

    /**
     * 一覧取得（ページャーなし）
     * @return View
     */
    public function index()
    {
//        dd("aa");

        $this->renderer->set('af', 'あふあふ');
        $condition = [];

        debug($this->repo->getCollection($condition));

        //データ一覧取得（＊ページャーなし）
        $this->renderer->set('samples', $this->repo->getCollection($condition));

        return view(Route::currentRouteName());
    }

//    /**
//     * list
//     * 検索画面（ページャー付き）
//     *
//     * @param SampleSearchRequest $request
//     * @return View
//     */
//    public function list(SampleSearchRequest $request): View
//    {
//        $searchConditions = $request->getValidatedData();
//
//
//        $this->renderer->setPaginator(
//            $this->repo->getViewModelPaginator(
//                route(Route::currentRouteName()),
//                $this->getRequestedPage($request),
//                $searchConditions
//            )
//        );
//
//        return view(Route::currentRouteName());
//    }
//
//    /**
//     * show
//     *
//     * @param $id
//     * @return View
//     */
//    public function show($id): View
//    {
//        if (empty($sample = $this->repo->getViewModel(['id' => $id]))) {
//            abort(404);
//        }
//
//        $this->renderer->setPageTitle('サンプル詳細');
//        $this->renderer->set('sample', $sample);
//
//        return view(Route::currentRouteName());
//    }
//
//    /**
//     * 登録画面
//     * @return View
//     */
//    public function input(): View
//    {
//        $this->renderer->setPageTitle('サンプル登録');
//
//        $this->renderer->set('next_url', route('master.sample.create'));
//        $this->renderer->set('sample', null);
//
//        return view(Route::currentRouteName());
//    }
//
//    public function create(SampleStoreRequest $request): RedirectResponse
//    {
//        $this->repo->store($request->getValidatedData());
//
//        return redirect(
//            route('master.sample.list')
//        )->with('status', 'サンプルを登録しました');
//    }
//
//    public function edit($id)
//    {
//        if (empty($sample = $this->repo->getViewModel(['id' => $id]))) {
//            abort(404);
//        }
//
//        $this->renderer->setPageTitle('サンプル編集');
//
//        $this->renderer->set('next_url', route('master.sample.update', $id));
//        $this->renderer->set('sample', $sample);
//
//        return view(Route::currentRouteName());
//    }
//
//    public function update($id, SampleStoreRequest $request): RedirectResponse
//    {
//        //TODO:is_null? empty?
//        if (empty($sample = $this->repo->getModel(['id' => $id]))) {
//            abort(404);
//        }
//
//        $this->repo->update($sample, $request->getValidatedData());
//
//        return redirect(
//            route('master.sample.show', $id)
//        )->with('status', 'サンプルを更新しました');
//    }
//
//    public function delete($id)
//    {
//        //TODO:is_null? empty?
//        if (empty($sample = $this->repo->getModel(['id' => $id]))) {
//            abort(404);
//        }
//
//        if ($this->repo->delete($sample)) {
//            $message = 'サンプルデータの削除に成功しました';
//        } else {
//            $message = 'サンプルデータの削除に失敗しました';
//        }
//
//        return redirect(
//            route('master.sample.list')
//        )->with('message', $message);
//    }
}