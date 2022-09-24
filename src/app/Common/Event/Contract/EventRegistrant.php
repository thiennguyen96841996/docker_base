<?php
namespace App\Common\Event\Contract;

/**
 * 各環境毎のイベント/リスナーを登録するクラスを表すインターフェイス。
 * @package \App\Common\Event
 */
interface EventRegistrant
{
    /**
     * イベント/リスナーを登録する。
     * @param  array<class-string, array<int, class-string>> $defaultEvents 共通で設定されているイベント/リスナーの配列
     * @return array<class-string, array<int, class-string>>
     */
    public function getEvents(array $defaultEvents): array;
}
