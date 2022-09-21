<?php
namespace GLC\Platform\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use GLC\Platform\Console\Contracts\Scheduler as SchedulerContract;

/**
 * Artisanに関連した設定や処理を行うクラス。
 *
 * @package GLC\Platform\Console
 * @author  TinhNC <tinhhang22@gmail.com>
 */
class Kernel extends ConsoleKernel
{

    /**
     * 定期実行処理を設定する。
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule Scheduleオブジェクト
     * @return void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function schedule(Schedule $schedule)
    {
        /*
         * [ Sample ]
         * $schedule->command(\GLC\Platform\Commands\Command::class, [])
         *          ->dailyAt('00:00');
         */

        /** @var SchedulerContract $scheduler */
        if (!empty($scheduler = app()->make(SchedulerContract::class))) {
            $scheduler->schedule($schedule);
        }
    }

    /**
     * アプリケーションで使用するArtisanコマンドを読み込んで使用可能にする。
     *
     * @return void
     */
    protected function commands()
    {
//        $this->load(__DIR__ . '/Commands');
        $this->load('GLC/Batch/Console/Commands');

        require base_path('routes/console.php');
    }
}