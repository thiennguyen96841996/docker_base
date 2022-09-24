<?php
namespace App\Common\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;
use App\Common\Console\Contract\CommandRegistrant as CommandRegistrantContact;

/**
 * Artisanコマンドの登録や設定を行うクラス。
 * @package \App\Common\Console
 */
class Kernel extends ConsoleKernel
{
    /**
     * 定期実行処理を設定する。
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // TODO Schedulerの切り分け処理
    }

    /**
     * Artisanコマンドを登録する。
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Command');

        // 共通のコマンドを読み込む
        (new CommandRegistrant())->registerCommands();

        // 環境毎のコマンドを読み込む
        if (!empty($class = config('speedy.command_registrant'))) {
            if (!class_exists($class)) {
                Log::error('CommandRegistrant class is not found. [class]:'.$class);
                return;
            }

            /** @var CommandRegistrantContact $instance */
            $instance = new $class;

            if (!is_subclass_of($class, CommandRegistrantContact::class)) {
                Log::error('CommandRegistrant class is not implement contract.');
                return;
            }
            $instance->registerCommands();
        }
    }
}
