<?php
namespace App\Common\AgencyContract\Contract;

use App\Common\AgencyContract\Model\AgencyContract;
use App\Common\Database\Contract\ModelRepository;

/**
 * AgencyContractモデルのデータ操作を扱うクラスを表すインターフェイス。
 * @package App\Common\AgencyContract\Contract
 */
interface AgencyContractRepository extends ModelRepository
{
    /**
     * 単一のAgencyContract情報を登録する。
     * @param array<string, mixed> $params
     * @return AgencyContract
     * @throws \Throwable
     */
    public function store(array $params): AgencyContract;

    /**
     * 単一の管理AgencyContractを更新する。
     * @param  array<string, mixed> $params
     * @param  AgencyContract $agencyContract
     * @return void
     * @throws \Throwable
     */
    public function update(AgencyContract $agencyContract, array $params): void;

    /**
     * 単一の管理AgencyContractを削除する。
     * @param  AgencyContract $agencyContract
     * @return void
     * @throws \Throwable
     */
    public function delete(AgencyContract $agencyContract): void;
}
