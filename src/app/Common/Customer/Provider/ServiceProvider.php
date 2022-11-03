<?php

namespace App\Common\Customer\Provider;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use App\Common\Customer\Contract\CustomerRepository as CustomerRepositoryContract;
use App\Common\Customer\Repository\CustomerRepository;

class ServiceProvider extends BaseServiceProvider implements DeferrableProvider
{
    public function register()
    {
        $this->app->bind(CustomerRepositoryContract::class, function () {
            return new CustomerRepository();
        });
    }

    public function provides(): array
    {
        return [
            CustomerRepositoryContract::class,
        ];
    }
}
