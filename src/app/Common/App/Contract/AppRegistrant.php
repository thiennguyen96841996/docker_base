<?php
namespace App\Common\App\Contract;

/**
 * 環境固有で必要なモジュールを登録するクラスを表すインターフェイス。
 * @package \App\Common\App
 */
interface AppRegistrant
{
    /**
     * 環境固有で必要なモジュールを登録する。
     * @return void
     */
    public function register(): void;
}
