<?php
namespace App\Common\Console;

use App\Common\Console\Contract\CommandRegistrant as CommandRegistrantContact;

/**
 * 各環境毎のコマンドを登録するクラス。<br>
 * ※ このクラスで登録されるコマンドは関連するアプリケーション共通のものとして扱われる。
 * @package \App\Common\Console
 */
class CommandRegistrant implements CommandRegistrantContact
{
    use CommandRegister;

    /**
     * 使用するコマンドの定義。
     * @var array<int, class-string>
     */
    protected array $commands = [];
}
