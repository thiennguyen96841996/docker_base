<?php
namespace GLC\Platform\Bootstrap\Contracts;

/**
 * アプリケーションに合わせた起動処理を行うクラスを表すインターフェイス。
 *
 * @package GLC\Platform\Bootstrap\Contracts
 * @author  TinhNC <tinhhang22@gmail.com>
 */
interface Bootstrap
{
    /**
     * 登録処理を行う。
     *
     * @return void
     */
    public function register();

    /**
     * 起動処理を行う。
     *
     * @return void
     */
    public function boot();

    /**
     * 起動時のコールバック処理を行う。
     *
     * @return void
     */
    public function callBootingCallbacks();

    /**
     * 起動後のコールバック処理を行う。
     *
     * @return void
     */
    public function callBootedCallbacks();
}