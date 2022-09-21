<?php
namespace GLC\Platform\Sms\Providers;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use GLC\Platform\Sms\Contracts\VerificationSmsRepository as VerificationSmsRepositoryContract;
use GLC\Platform\Sms\Repositories\VerificationSmsRepository;

/**
 * Smsパッケージを使用するのに必要な処理を行うプロバイダークラス。
 *
 * @package GLC\Platform\Sms\Providers
 * @author  TinhNC <tinhhang22@gmail.com>
 */
class PackageServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * サービスの登録処理を行う。
     *
     * @return void
     */
    public function register()
    {
        // VerificationSmsRepository
        $this->app->bind(VerificationSmsRepositoryContract::class, function() {
            return new VerificationSmsRepository();
        });
    }

    /**
     * このクラスが提供するサービスの配列を返す。
     *
     * @return array
     */
    public function provides(): array
    {
        return [
            VerificationSmsRepositoryContract::class,
        ];
    }
}