<?php

namespace App\Common\Sample\Provider;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use App\Common\Sample\Contract\SampleRepository as SampleRepositoryContract;
use App\Common\Sample\Repository\SampleRepository;

class ServiceProvider extends BaseServiceProvider implements DeferrableProvider
{
    public function register()
    {
        $this->app->bind(SampleRepositoryContract::class, function () {
            return new SampleRepository();
        });
    }

    public function provides(): array
    {
        return [
            SampleRepositoryContract::class,
        ];
    }
}
