<?php

namespace GLC\Platform\Sample\Providers;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use GLC\Platform\Sample\Contracts\SampleRepositoryContract;
use GLC\Platform\Sample\Repositories\SampleRepository;
use GLC\Platform\Sample\ViewModels\SampleViewModel;

class PackageServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function register()
    {
        $this->app->bind(SampleRepositoryContract::class, function () {
            $repository = new SampleRepository();

            //TODO:setViewModel?
            $repository->setViewModel(new SampleViewModel());
            return $repository;
        });
    }

    public function provides(): array
    {
        return [
            SampleRepositoryContract::class,
        ];
    }
}