<?php
namespace GLC\Platform\Repository\Contracts;

use Illuminate\Support\Collection;

/**
 * 各モデルのリポジトリを表すインターフェイス。
 *
 * @package GLC\Platform\Repository\Contracts
 * @author  TinhNC <tinhhang22@gmail.com>
 */
interface ModelRepository
{
    /**
     * 検索条件に合致したデータを取得して返す。
     *
     * @param  array $searchConditions 検索条件の配列
     * @return \Illuminate\Support\Collection|null Modelクラスのコレクション or null
     */
    public function getCollection(array $searchConditions): ?Collection;

    /**
     * 検索条件に合致した単一のデータを取得して返す。
     *
     * @param  array $searchConditions 検索条件の配列
     * @return \Illuminate\Database\Eloquent\Model|null Modelクラス or null
     */
    public function getModel(array $searchConditions);
}