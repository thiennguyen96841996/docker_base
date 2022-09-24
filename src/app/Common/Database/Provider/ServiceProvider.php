<?php
namespace App\Common\Database\Provider;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use App\Common\Database\Contract\RepositoryRegistrant as RepositoryRegistrantContract;

/**
 * データベースに関わるサービスの登録や設定を行うクラス。
 * @package \App\Common\Database
 */
class ServiceProvider extends BaseServiceProvider
{
    /**
     * サービスを登録する。
     * @return void
     */
    public function register()
    {
    }

    /**
     * サービスを起動する。
     * @return void
     */
    public function boot()
    {
        // 環境毎のリポジトリーを読み込む
        if (!empty($class = config('speedy.repository_registrant'))) {
            if (!class_exists($class)) {
                Log::error('RepositoryRegistrant class is not found. [class]:'.$class);
                return;
            }
            /** @var RepositoryRegistrantContract $instance */
            $instance = new $class;

            if (!is_subclass_of($class, RepositoryRegistrantContract::class)) {
                Log::error('RepositoryRegistrant class is not implement contract.');
                return;
            }
            $instance->registerRepositories();
        }
    }
}
