<?php
namespace GLC\Platform\Migration\Providers;

use Illuminate\Database\MigrationServiceProvider as ServiceProvider;
use GLC\Platform\Migration\Commands\FakeFreshCommand;
use GLC\Platform\Migration\Commands\FakeRefreshCommand;
use GLC\Platform\Migration\Commands\FakeResetCommand;

/**
 * 一部の機能制限を施したMigrationServiceProviderクラス。
 * ※ 制限が不要であれば使わなくても良い。
 *
 * @package GLC\Platform\Migration\Providers
 * @author  TinhNC <tinhhang22@gmail.com>
 */
class PackageServiceProvider extends ServiceProvider
{
    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerMigrateFreshCommand()
    {
        if (config('app.env') === 'vagrant' || config('app.env') === 'development' ) {
            parent::registerMigrateFreshCommand();
        } else {
            $this->app->singleton('command.migrate.fresh', function () {
                return new FakeFreshCommand();
            });
        }
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerMigrateRefreshCommand()
    {
        if (config('app.env') === 'vagrant' || config('app.env') === 'development' ) {
            parent::registerMigrateRefreshCommand();
        } else {
            $this->app->singleton('command.migrate.refresh', function () {
                return new FakeRefreshCommand();
            });
        }
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerMigrateResetCommand()
    {
        if (config('app.env') === 'vagrant' || config('app.env') === 'development' ) {
            parent::registerMigrateResetCommand();
        } else {
            $this->app->singleton('command.migrate.reset', function () {
                return new FakeResetCommand();
            });
        }
    }
}