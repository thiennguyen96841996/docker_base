<?php
namespace GLC\Platform\Auth\Providers;

use Illuminate\Auth\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Blade;
use GLC\Platform\Auth\Contracts\AuthRepository as RepositoryContract;
use GLC\Platform\Auth\Models\AuthEmployee;
use GLC\Platform\Auth\Models\AuthUser;
use GLC\Platform\Auth\Repositories\AuthRepository;
use GLC\Platform\Customer\Models\Customer;
use GLC\Platform\User\Definitions\UserDefs;

/**
 * Authパッケージを使用するのに必要な処理を行うプロバイダークラス。
 * 基本となる\Illuminate\Auth\AuthServiceProviderを継承し、Auth機能を状況によって変更可能にしている。
 * また、標準的なアプリケーション用のAuthServiceProviderの機能も持つ。
 *
 * @package GLC\Platform\Auth\Providers
 * @author  TinhNC <tinhhang22@gmail.com>
 */
abstract class AbsPackageServiceProvider extends ServiceProvider
{
    /**
     * ポリシーとそれに対応するモデルのマッピング。
     * @var array
     */
    protected $policies = [
        // \GLC\Platform\Auth\Models\Model::class => \GLC\Platform\Auth\Policies\ModelPolicy::class,
    ];

    /**
     * 認証用のルートを取得する。
     *
     * ex)
     * return [
     *     'name' => [
     *         'authenticated'  => 'xxxxx.dashboard.index',
     *         'guest'          => 'xxxxx.login.index',
     *         'password_edit'  => 'xxxxx.password.index',
     *         'password_reset' => 'xxxxx.password.reset.edit'
     *     ]
     * ];
     *
     * @return array
     */
    abstract protected function getAuthRoutes(): array;

    /**
     * サービスの登録処理を行う。
     *
     * @return void
     */
    public function register()
    {
        Config::set('auth', $this->getConfig());
        $this->registerAuthRepository();

        parent::register();
    }

    /**
     * サービスの起動処理を行う。
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }

    /**
     * ポリシーを登録する。
     *
     * @return void
     */
    public function registerPolicies()
    {
        foreach ($this->policies() as $key => $value) {
            Gate::policy($key, $value);
        }
    }

    /**
     * ポリシーを取得する。
     *
     * @return array
     */
    public function policies(): array
    {
        return $this->policies;
    }

    /**
     * 認証に関連した処理を行うリポジトリクラスを登録する。
     *
     * @return void
     */
    protected function registerAuthRepository()
    {
        $this->app->bind(RepositoryContract::class, function () {
            $repository = new AuthRepository();
            return $repository;
        });
    }

    /**
     * 認証の基本設定を取得する。
     *
     * @return array
     */
    protected function getConfig(): array
    {
        $route = $this->getAuthRoutes();

        return [
            /*
            |--------------------------------------------------------------------------
            | Authentication Defaults
            |--------------------------------------------------------------------------
            |
            | This option controls the default authentication "guard" and password
            | reset options for your application. You may change these defaults
            | as required, but they're a perfect start for most applications.
            |
            */
            'defaults' => [
                'guard'     => 'platform',
                'passwords' => 'platform',
            ],

            'client' => [
                'guard'     => 'client',
                'passwords' => 'client',
            ],

            /*
            |--------------------------------------------------------------------------
            | Authentication Guards
            |--------------------------------------------------------------------------
            |
            | Next, you may define every authentication guard for your application.
            | Of course, a great default configuration has been defined for you
            | here which uses session storage and the Eloquent user provider.
            |
            | All authentication drivers have a user provider. This defines how the
            | users are actually retrieved out of your database or other storage
            | mechanisms used by this application to persist your user's data.
            |
            | Supported: "session", "token"
            |
            */
            'guards' => [
                'platform' => [
                    'driver'   => 'session',
                    'provider' => 'platform',
                ],
                'client' => [
                    'driver'   => 'session',
                    'provider' => 'client',
                ],
                'api' => [
                    'driver' => 'passport',
                    'provider' => 'customer',
                ],
            ],

            /*
            |--------------------------------------------------------------------------
            | User Providers
            |--------------------------------------------------------------------------
            |
            | All authentication drivers have a user provider. This defines how the
            | users are actually retrieved out of your database or other storage
            | mechanisms used by this application to persist your user's data.
            |
            | If you have multiple user tables or models you may configure multiple
            | sources which represent each model / table. These sources may then
            | be assigned to any extra authentication guards you have defined.
            |
            | Supported: "database", "eloquent"
            |
            */
            'providers' => [
                'platform' => [
                    'driver' => 'eloquent',
                    'model'  => AuthUser::class,
                ],
                'client' => [
                    'driver' => 'eloquent',
                    'model'  => AuthEmployee::class,
                ],
                'customer' => [
                    'driver' => 'eloquent',
                    'model'  => Customer::class,
                ],
            ],

            /*
            |--------------------------------------------------------------------------
            | Resetting Passwords
            |--------------------------------------------------------------------------
            |
            | You may specify multiple password reset configurations if you have more
            | than one user table or model in the application and you want to have
            | separate password reset settings based on the specific user types.
            |
            | The expire time is the number of minutes that the reset token should be
            | considered valid. This security feature keeps tokens short-lived so
            | they have less time to be guessed. You may change this as needed.
            |
            */
            'passwords' => [
                'platform' => [
                    'provider' => 'platform',
                    'table'    => 'user_password_reset_tokens',
                    'expire'   => 60,
                ],
                'client' => [
                    'provider' => 'client',
                    'table'    => 'employee_password_reset_tokens',
                    'expire'   => 60,
                ],
            ],

            /*
            |--------------------------------------------------------------------------
            | Password Confirmation Timeout
            |--------------------------------------------------------------------------
            |
            | Here you may define the amount of seconds before a password confirmation
            | times out and the user is prompted to re-enter their password via the
            | confirmation screen. By default, the timeout lasts for three hours.
            |
            */
            'password_timeout' => 10800,

            /*
            |--------------------------------------------------------------------------
            | Routes
            |--------------------------------------------------------------------------
            */
            'routes' => $route
        ];
    }
}