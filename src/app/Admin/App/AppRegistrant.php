<?php
namespace App\Admin\App;

use App\Common\App\Contract\AppRegistrant as AppRegistrantContract;

/**
 * 環境固有で必要なモジュールを登録するクラス。
 * @package \App\Admin\App
 */
class AppRegistrant implements AppRegistrantContract
{
    /**
     * 環境固有で必要なモジュールを登録する。
     * @return void
     */
    public function register(): void
    {
    }
}
