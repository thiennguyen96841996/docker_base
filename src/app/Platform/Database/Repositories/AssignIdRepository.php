<?php
namespace GLC\Platform\Database\Repositories;

use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use GLC\Platform\Database\Definitions\DatabaseDefs;
use GLC\Platform\Database\Models\AssignId;
use GLC\Platform\Database\Contracts\AssignIdRepository as RepositoryContract;

/**
 * AssignIdモデルに関連した処理を行うリポジトリクラス。
 *
 * @package GLC\Platform\Database\Repositories
 * @author  TinhNC <tinhhang22@gmail.com>
 */
class AssignIdRepository implements RepositoryContract
{
    /**
     * 検索条件に合致したデータを取得して返す。
     *
     * @param  array $searchConditions 検索条件の配列
     * @return \Illuminate\Support\Collection|null AssignIdのCollectionオブジェクト or null
     * @throws \Throwable
     */
    public function getCollection(array $searchConditions = []): ?Collection
    {
        /** @var \GLC\Platform\Database\Models\AssignId $builder */
        $builder = AssignId::on(DatabaseDefs::CONNECTION_NAME_READ)
            ->addSelect([
                '*'
            ]);

        return $builder->whereMultiConditions($searchConditions)->get();
    }

    /**
     * 検索条件に合致した単一のデータを取得して返す。
     *
     * @param  array $searchConditions 検索条件の配列
     * @return \GLC\Platform\Database\Models\AssignId|null AssignIdオブジェクト or null
     * @throws \Throwable
     */
    public function getModel(array $searchConditions): ?AssignId
    {
        $collection = $this->getCollection($searchConditions);

        return $collection->count() === 1 ? $collection->first(): null;
    }

    /**
     * 新しいIDを割り当てる。
     *
     * @param  string $prefix 取得したいIDのプリフィックス
     * @return string
     * @throws \Throwable
     */
    public function assignNewId(string $prefix): string
    {
        return DB::connection(DatabaseDefs::CONNECTION_NAME_WRITE)->transaction(function () use ($prefix) {
            /** @var \GLC\Platform\Database\Models\AssignId $assignId */
            $assignId = AssignId::on(DatabaseDefs::CONNECTION_NAME_WRITE)
                ->where('prefix', '=' , $prefix)
                ->lockForUpdate()
                ->first();

            if (is_null($assignId)) {
                throw new Exception("Target prefix is not stored. [prefix:{$prefix}]");
            }

            //新IDを生成
            $newId = str_pad($assignId->count, 8, 0, STR_PAD_LEFT);
            $newId = $prefix . $newId;

            // カウントアップして更新する
            $assignId->count++;
            $assignId->save();

            return $newId;
        });
    }
}