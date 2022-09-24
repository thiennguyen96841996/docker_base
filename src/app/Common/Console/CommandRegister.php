<?php
namespace App\Common\Console;

use ReflectionClass;
use ReflectionException;
use Illuminate\Console\Application as Artisan;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

/**
 * コマンドを登録する為の関数を持つトレイト。
 * @package \App\Common\Console
 */
trait CommandRegister
{
    /**
     * コマンドを登録する。
     * @return void
     */
    public function registerCommands(): void
    {
        foreach ($this->commands as $command) {
            try {
                if (is_subclass_of($command, Command::class) && ! (new ReflectionClass($command))->isAbstract()) {
                    Artisan::starting(function ($artisan) use ($command) {
                        /** @var Artisan $artisan */
                        $artisan->resolve($command);
                    });
                }
            } catch (ReflectionException $e) {
                Log::error($e->getMessage());
            }
        }
    }
}
