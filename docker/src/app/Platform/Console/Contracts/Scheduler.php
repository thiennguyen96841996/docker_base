<?php
namespace GLC\Platform\Console\Contracts;

use Illuminate\Console\Scheduling\Schedule;

/**
 * アプリケーションに合わせた定期処理を設定するクラスを表すインターフェイス。
 *
 * @package GLC\Platform\Console\Contracts
 * @author  TinhNC <tinhhang22@gmail.com>
 */
interface Scheduler
{
    /**
     * 定期実行処理を設定する。
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule Scheduleオブジェクト
     * @return void
     */
    public function schedule(Schedule $schedule);
}