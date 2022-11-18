<?php

namespace App\Common\AgencyContract\Provider;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use App\Common\AgencyContract\Contract\AgencyContractRepository as AgencyContractRepositoryContract;
use App\Common\AgencyContract\Repository\AgencyContractRepository;

class ServiceProvider extends BaseServiceProvider implements DeferrableProvider
{
    public function register()
    {
        $this->app->bind(AgencyContractRepositoryContract::class, function () {
            return new AgencyContractRepository();
        });
    }

    public function provides(): array
    {
        return [
            AgencyContractRepositoryContract::class,
        ];
    }
}
