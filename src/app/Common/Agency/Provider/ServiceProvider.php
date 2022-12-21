<?php

namespace App\Common\Agency\Provider;

use App\Common\Agency\CsvViewModel\AgencyCsvViewModel;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use App\Common\Agency\Contract\AgencyRepository as AgencyRepositoryContract;
use App\Common\Agency\Repository\AgencyRepository;
use App\Common\Agency\Contract\AgencyCsvViewModel as AgencyCsvViewModelContract;

class ServiceProvider extends BaseServiceProvider implements DeferrableProvider
{
    public function register()
    {
        $this->app->bind(AgencyRepositoryContract::class, function () {
            return new AgencyRepository();
        });

        $this->app->bind(AgencyCsvViewModelContract::class, function () {
            return new AgencyCsvViewModel();
        });
    }

    public function provides(): array
    {
        return [
            AgencyRepositoryContract::class,
            AgencyCsvViewModelContract::class,
        ];
    }
}
