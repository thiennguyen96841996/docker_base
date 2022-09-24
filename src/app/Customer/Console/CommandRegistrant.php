<?php
namespace App\Customer\Console;

use App\Common\Console\CommandRegister;
use App\Common\Console\Contract\CommandRegistrant as CommandRegistrantContact;

/**
 * 各環境毎のコマンドを登録するクラス。
 * @package \App\Customer\Console
 */
class CommandRegistrant implements CommandRegistrantContact
{
    use CommandRegister;

    /**
     * 使用するコマンドの定義。
     * @var array<int, class-string>
     */
    protected array $commands = [
    ];
}
