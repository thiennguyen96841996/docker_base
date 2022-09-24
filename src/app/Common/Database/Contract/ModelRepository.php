<?php
namespace App\Common\Database\Contract;

/**
 * モデルのデータ操作を扱うクラスを表すインターフェイス。
 * @package \App\Common\Database
 */
interface ModelRepository
{
    /**
     * 検索条件に合致したデータを持つモデルのコレクションを取得する。
     * ※ 継承したクラスで戻り値の型指定をする為、ここではしない
     * @param  array<string, mixed> $searchConditions
     * @param  array<string, mixed> $selectColumns
     * @return \Illuminate\Support\Collection
     * @noinspection PhpMissingReturnTypeInspection
     */
    public function fetchAll(array $searchConditions, array $selectColumns = ['*']);

    /**
     * 検索条件に合致したデータを持つモデルをページネーターとして取得する。
     * ※ 継承したクラスで戻り値の型指定をする為、ここではしない
     * @param  array<string, mixed> $searchConditions
     * @param  array<string, mixed> $selectColumns
     * @return \Illuminate\Contracts\Pagination\Paginator
     * @noinspection PhpMissingReturnTypeInspection
     */
    public function fetchAsPaginator(array $searchConditions, array $selectColumns = ['*']);

    /**
     * 検索条件に合致した単一のモデルを取得する。
     * ※ 継承したクラスで戻り値の型指定をする為、ここではしない
     * @param  array<string, mixed> $searchConditions
     * @param  array<string, mixed> $selectColumns
     * @return \Illuminate\Database\Eloquent\Model|null
     * @noinspection PhpMissingReturnTypeInspection
     */
    public function fetchOne(array $searchConditions, array $selectColumns = ['*']);
}
