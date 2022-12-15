<?php

namespace App\Admin\Project\Controller;

use Illuminate\View\View;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Common\View\Facades\Renderer;
use Illuminate\Support\Facades\Route;
use App\Common\Project\Service\ProjectService;
use App\Common\Http\Controller\AbsController;

/**
 * Project page in admin site。
 * @package \App\Admin\Project
 */
class ProjectController extends AbsController
{
    /**
     * @var ProjectService
     */
    private ProjectService $projectService;

    /**
     * constructor.
     */
    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    /**
     * List Project's information
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        Renderer::setPageTitle('Danh sách dự án');

        Renderer::setPaginator($this->projectService->getViewModelPaginator(url()->current(), $request->all()));
        Renderer::setSearchConditions($request->all());

        return view('project.' . Arr::last(explode('.', Route::current()->getName())));
    }

    /**
     * Display Project's detail
     *
     * @param string $id
     * @return View
     * @throws \Throwable
     */
    public function show(string $id): View
    {
        Renderer::setPageTitle('Dự án ' . $id);

        if (empty($project = $this->projectService->getViewModel(['id' => $id]))) {
            return view('error.404');
        }
        Renderer::set('project', $project);

        return view('project.' . Arr::last(explode('.', Route::current()->getName())));
    }
}
