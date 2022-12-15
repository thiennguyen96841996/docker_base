<?php

namespace App\Common\Project\Provider;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use App\Common\Project\Contract\ProjectRepository as ProjectRepositoryContract;
use App\Common\Project\Repository\ProjectRepository;

class ServiceProvider extends BaseServiceProvider implements DeferrableProvider
{
    public function register()
    {
        $this->app->bind(ProjectRepositoryContract::class, function () {
            return new ProjectRepository();
        });
    }

    public function provides(): array
    {
        return [
            ProjectRepositoryContract::class,
        ];
    }
}
