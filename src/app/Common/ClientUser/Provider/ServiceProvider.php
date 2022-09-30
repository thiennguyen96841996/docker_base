<?php

namespace App\Common\ClientUser\Provider;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use App\Common\ClientUser\Contract\ClientUserRepository as ClientUserRepositoryContract;
use App\Common\ClientUser\Repository\ClientUserRepository;

class ServiceProvider extends BaseServiceProvider implements DeferrableProvider
{
    public function register()
    {
        $this->app->bind(ClientUserRepositoryContract::class, function () {
            return new ClientUserRepository();
        });
    }

    public function provides(): array
    {
        return [
            ClientUserRepositoryContract::class,
        ];
    }
}
