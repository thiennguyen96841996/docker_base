<?php
namespace App\Client\Event;

use App\Common\Event\Contract\EventRegistrant as EventRegistrantContract;

/**
 * 各環境毎のイベント/リスナーを登録するクラス。
 * @package \App\Client\Event
 */
class EventRegistrant implements EventRegistrantContract
{
    /**
     * イベントとそのリスナーのマッピングの定義。
     * @var array<class-string, array<int, class-string>>
     */
    private array $listen = [
        \Illuminate\Auth\Events\Login::class => [
            \App\Client\Auth\Event\Listener\LoginEventListener::class,
        ]
    ];

    /**
     * イベント/リスナーを登録する。
     * @param  array<class-string, array<int, class-string>> $defaultEvents 共通で設定されているイベント/リスナーの配列
     * @return array<class-string, array<int, class-string>>
     */
    public function getEvents(array $defaultEvents): array
    {
        return collect($defaultEvents)->union($this->listen)->all();
    }
}
