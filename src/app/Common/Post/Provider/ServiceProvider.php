<?php

namespace App\Common\Post\Provider;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use App\Common\Post\Contract\PostRepository as PostRepositoryContract;
use App\Common\Post\Repository\PostRepository;

class ServiceProvider extends BaseServiceProvider implements DeferrableProvider
{
    public function register()
    {
        $this->app->bind(PostRepositoryContract::class, function () {
            return new PostRepository();
        });
    }

    public function provides(): array
    {
        return [
            PostRepositoryContract::class,
        ];
    }
}
