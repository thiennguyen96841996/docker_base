<?php
namespace App\Common\Repository\Contract;

use Illuminate\Support\Collection;

/**
 * 各モデルのリポジトリを表すインターフェイス。
 *
 * @package App\Common\Repository\Contract
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
