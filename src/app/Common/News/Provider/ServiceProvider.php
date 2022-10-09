<?php

namespace App\Common\News\Provider;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use App\Common\News\Contract\NewsRepository as NewsRepositoryContract;
use App\Common\News\Repository\NewsRepository;

class ServiceProvider extends BaseServiceProvider implements DeferrableProvider
{
    public function register()
    {
        $this->app->bind(NewsRepositoryContract::class, function () {
            return new NewsRepository();
        });
    }

    public function provides(): array
    {
        return [
            NewsRepositoryContract::class,
        ];
    }
}
