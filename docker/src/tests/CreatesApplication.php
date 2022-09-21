<?php
namespace Tests;

use Illuminate\Contracts\Console\Kernel;

/**
 * Applicationクラスを作成するための関数を持つトレイト。
 *
 * @package Tests
 * @author  TinhNC <tinhhang22@gmail.com>
 */
trait CreatesApplication
{
    /**
     * Kernelを実装したオブジェクトを実装したクラスを取得する。
     *
     * @return \Illuminate\Contracts\Console\Kernel Kernelを実装したオブジェクト
     */
    public function createApplication(): Kernel
    {
        $app = require __DIR__ . '/../bootstrap/app.php';
        $app->make(Kernel::class)->bootstrap();
        return $app;
    }
}