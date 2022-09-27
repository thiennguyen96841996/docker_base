<?php
namespace App\Common\Repository\Contract;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

/**
 * ViewModelに対応したリポジトリを表すインターフェイス。
 *
 * @package App\Common\Repository\Contract
 * @author  Ritsuki Sugiyama <sugiyama.r@tsunagu-grp.jp>
 */
interface ViewModelRepository extends ModelRepository
{
    // TODO レプリケーション遅延対象で、一旦対象画面のリポジトリにだけwriteConnection処理入れてるので一旦コメント・・
//    /**
//     * 検索条件に合致した単一のデータを取得し、ViewModelにして返す。
//     *
//     * @param  array $searchConditions 検索条件の配列
//     * @return \Illuminate\Support\Collection|null 取得したデータから作成されたViewModelのコレクション or null
//     */
//    public function getViewModelCollection(array $searchConditions = []): ?Collection;
//
//    /**
//     * 検索条件に合致した単一のデータを取得し、ViewModelにして返す。
//     *
//     * @param array $searchConditions 検索条件の配列
//     * @param bool $writeConnection
//     * @return \App\Common\View\Contract\ViewModel|null 取得したデータから作成されたViewModel or null
//     */
//    public function getViewModel(array $searchConditions, bool $writeConnection = false);
//
//    /**
//     * ViewModelのデータをPaginatorとして取得する。
//     *
//     * @param  string $path URLの元になるパス
//     * @param  int $page ページ番号
//     * @param  array $searchConditions 検索条件の配列
//     * @return \Illuminate\Pagination\LengthAwarePaginator
//     */
//    public function getViewModelPaginator(string $path, int $page, array $searchConditions = []): LengthAwarePaginator;
}
