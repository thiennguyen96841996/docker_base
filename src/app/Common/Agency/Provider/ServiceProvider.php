<?php

namespace App\Common\Agency\Provider;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use App\Common\Agency\Contract\AgencyRepository as AgencyRepositoryContract;
use App\Common\Agency\Repository\AgencyRepository;

class ServiceProvider extends BaseServiceProvider implements DeferrableProvider
{
    public function register()
    {
        $this->app->bind(AgencyRepositoryContract::class, function () {
            return new AgencyRepository();
        });
    }

    public function provides(): array
    {
        return [
            AgencyRepositoryContract::class,
        ];
    }
}
