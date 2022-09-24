<?php
namespace App\Common\Auth\Provider;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as BaseServiceProvider;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;
use App\Common\Auth\Contract\PolicyRegistrant as PolicyRegistrantContract;

/**
 * 認証に関連する設定と登録を行うクラス。
 * @package \App\Common\Auth
 */
class ServiceProvider extends BaseServiceProvider
{
    /**
     * ポリシーとそれに対応するモデルのマッピングの定義。
     * @var array<class-string, class-string>
     */
    protected $policies = [];

    /**
     * サービスの起動処理を行う。
     * @return void
     */
    public function boot()
    {
        // 環境毎のポリシーを読み込む
        if (!empty($class = config('speedy.policy_registrant'))) {
            if (!class_exists($class)) {
                Log::error('PolicyRegistrant class is not found. [class]:'.$class);
                return;
            }
            /** @var PolicyRegistrantContract $instance */
            $instance = new $class;

            if (!is_subclass_of($class, PolicyRegistrantContract::class)) {
                Log::error('PolicyRegistrant class is not implement contract.');
                return;
            }
            $this->policies = $instance->getPolicies($this->policies);
        }
        $this->registerPolicies();

        // パスワードの基準を設定する
        Password::defaults(function (){
            return Password::min(8)
                ->letters()
                ->numbers()
                ->symbols()
                ->mixedCase();
        });
    }
}
