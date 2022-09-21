<?php
namespace GLC\Platform\Console\Providers;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Foundation\Providers\ArtisanServiceProvider;
use Illuminate\Foundation\Providers\ComposerServiceProvider;
use Illuminate\Support\AggregateServiceProvider;
use GLC\Platform\Migration\Providers\PackageServiceProvider as MigrationProvider;

/**
 * 一部のマイグレーション機能に制限を施したConsoleSupportServiceProvider。
 *
 * @package GLC\Platform\Console\Providers
 * @author  TinhNC <tinhhang22@gmail.com>
 */
class PackageServiceProvider extends AggregateServiceProvider implements DeferrableProvider
{
    /**
     * The provider class names.
     *
     * @var array
     */
    protected $providers = [
        ArtisanServiceProvider::class,
        MigrationProvider::class,
        ComposerServiceProvider::class,
    ];
}