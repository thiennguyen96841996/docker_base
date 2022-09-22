<?php
namespace GLC\Platform\Firebase\Repositories;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use GLC\Platform\Firebase\Models\DeviceToken;
use GLC\Platform\Database\Definitions\DatabaseDefs;
use GLC\Platform\Repository\ViewModelRepositoryTrait;
use GLC\Platform\Firebase\Contracts\DeviceTokenRepository as RepositoryContract;

/**
 * DeviceTokenモデルに関連した処理を行うリポジトリクラス。
 *
 * @package GLC\Platform\Firebase\Repositories
 */
class DeviceTokenRepository implements RepositoryContract
{
    use ViewModelRepositoryTrait;

    /**
     * DeviceTokenRepository constructor.
     *
     */
    public function __construct()
    {
    }

    /**
     * 検索条件に合致したデータを取得して返す。
     *
     * @param  array $searchConditions 検索条件の配列
     * @return \Illuminate\Support\Collection|null SDeviceTokenのCollectionオブジェクト or null
     * @throws \Throwable
     */
    public function getCollection(array $searchConditions = []): ?Collection
    {
        /** @var \GLC\Platform\Firebase\Models\DeviceToken $builder */
        $builder = DeviceToken::on(DatabaseDefs::CONNECTION_NAME_READ_SECURE)
            ->addSelect([
                DeviceToken::TABLE_NAME.'.*' ,
            ])
            ->orderBy('updated_at', 'desc');

        return $builder->whereMultiConditions($searchConditions)->get();
    }

    /**
     * 検索条件に合致した単一のデータを取得して返す。
     *
     * @param  array $searchConditions 検索条件の配列
     * @return \GLC\Platform\Firebase\Models\DeviceToken|null DeviceTokenオブジェクト or null
     * @throws \Throwable
     */
    public function getModel(array $searchConditions): ?DeviceToken
    {
        $collection = $this->getCollection($searchConditions);

        return $collection->count() === 1 ? $collection->first(): null;
    }

    /**
     * 新規データを登録する。
     *
     * @param  array $storeData
     * @throws \Throwable
     */
    public function store(array $storeData)
    {
        DB::connection(DatabaseDefs::CONNECTION_NAME_WRITE_SECURE)->transaction(function () use($storeData) {
            $regData = new DeviceToken();
            $regData->customer_id = Arr::get($storeData, 'customer_id');
            $regData->device_token = Arr::get($storeData, 'device_token');
            $regData->created_at = $regData->updated_at = date('Y-m-d H:i:s');
            $regData->setConnection(DatabaseDefs::CONNECTION_NAME_WRITE_SECURE)->save();
        });
    }
}