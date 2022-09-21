<?php
namespace GLC\Platform\Firebase\Contracts;

use GLC\Platform\Repository\Contracts\ModelRepository;

/**
 * DeviceTokenモデルに関連した処理を行うリポジトリを表すインターフェイス。
 *
 * @package GLC\Platform\Firebase\Contracts
 */
interface DeviceTokenRepository extends ModelRepository
{
    /**
     * 新規データを登録する。
     *
     * @param  array $storeData
     * @throws \Throwable
     */
    public function store(array $storeData);
}