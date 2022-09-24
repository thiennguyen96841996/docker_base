<?php
namespace App\Common\Console\Contract;

/**
 * 各環境毎のコマンドを登録するクラスを表すインターフェイス。
 * @package \App\Common\Console
 */
interface CommandRegistrant
{
    /**
     * コマンドを登録する。
     * @return void
     */
    public function registerCommands(): void;
}
