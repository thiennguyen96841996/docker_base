<?php
namespace App\Common\Event\Provider;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as BaseServiceProvider;
use Illuminate\Support\Facades\Log;
use App\Common\Event\Contract\EventRegistrant as EventRegistrantContract;

/**
 * イベント/リスナーに関わるサービスの登録や設定を行うクラス。
 * @package \App\Common\Event
 */
class ServiceProvider extends BaseServiceProvider
{
    /**
     * イベントとそのリスナーのマッピングの定義。
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [];

    /**
     * サービスを登録する。
     * @return void
     */
    public function register()
    {
        // 環境毎のイベント/リスナーを読み込む
        if (!empty($class = config('speedy.event_registrant'))) {
            if (!class_exists($class)) {
                Log::error('EventRegistrant class is not found. [class]:'.$class);
                return;
            }
            /** @var EventRegistrantContract $instance */
            $instance = new $class;

            if (!is_subclass_of($class, EventRegistrantContract::class)) {
                Log::error('EventRegistrant class is not implement contract.');
                return;
            }
            $this->listen = $instance->getEvents($this->listen);
        }

        parent::register();
    }

    /**
     * イベントとリスナーを自動で検知するかどうか
     * @return bool
     * @noinspection PhpMissingReturnTypeInspection
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
