<?php
namespace App\Common\View\Contract;

use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Bladeから使用する描画系のサポートクラスを表すインターフェイス。
 *
 * @package App\Common\View\Contracts
 */
interface Renderer
{
    // TODO 要件として必須の関数を精査して定義する。

    /**
     * ページタイトルを取得する。
     *
     * @param  string $default デフォルトのページタイトル
     * @return string
     */
    public function setPageTitle(string $pageTitle);

    /**
     * Paginatorを設定する。
     *
     * @param  \Illuminate\Pagination\LengthAwarePaginator $paginator LengthAwarePaginatorオブジェクト
     * @return void
     */
    public function setPaginator(LengthAwarePaginator $paginator);

    /**
     * $offsetに紐づくデータを設定する。
     * ※ offsetSetのエイリアス
     *
     * @param  mixed $key 連想配列のキー
     * @param  mixed $value $offsetに紐付けるデータ
     * @return void
     */
    public function set(mixed $key, mixed $value);
}
