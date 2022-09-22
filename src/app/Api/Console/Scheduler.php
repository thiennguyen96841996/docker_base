<?php
namespace GLC\Api\Console;

use Illuminate\Console\Scheduling\Schedule;
use GLC\Platform\Console\Contracts\Scheduler as SchedulerContract;

/**
 * アプリケーションに合わせた定期処理を設定するクラス。
 *
 * @package Konohni\Api\Console
 * @author  TinhNC <tinhhang22@gmail.com>
 */
class Scheduler implements SchedulerContract
{
    /**
     * 定期実行処理を設定する。
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule Scheduleオブジェクト
     * @return void
     */
    public function schedule(Schedule $schedule)
    {
        /*
         * [ Sample ]
         * $schedule->command(\GLC\Api\Console\Commands\Command::class, [])
         *          ->dailyAt('00:00');
         */
    }
}