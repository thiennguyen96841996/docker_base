<?php

namespace App\Common\BookmarkLink\Provider;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use App\Common\BookmarkLink\Contract\BookmarkLinkRepository as BookmarkLinkRepositoryContract;
use App\Common\BookmarkLink\Repository\BookmarkLinkRepository;

class ServiceProvider extends BaseServiceProvider implements DeferrableProvider
{
    public function register()
    {
        $this->app->bind(BookmarkLinkRepositoryContract::class, function () {
            return new BookmarkLinkRepository();
        });
    }

    public function provides(): array
    {
        return [
            BookmarkLinkRepositoryContract::class,
        ];
    }
}
