<?php
namespace App\Common\Agency\Contract;

use App\Common\Agency\Model\Agency;
use App\Common\Database\Contract\ModelRepository;

/**
 * Sampleモデルのデータ操作を扱うクラスを表すインターフェイス。
 * @package \App\Common\Sample
 */
interface AgencyRepository extends ModelRepository
{
    /**
     * 単一の管理ユーザー情報を登録する。
     * @param  array<string, mixed> $params
     * @return \App\Common\Agency\Model\Agency
     * @throws \Throwable
     */
    public function store(array $params): Agency;

    /**
     * 単一の管理ユーザー情報を更新する。
     * @param  array<string, mixed> $params
     * @param  \App\Common\Agency\Model\Agency $sample
     * @return void
     * @throws \Throwable
     */
    public function update(Agency $Sample, array $params): void;

    /**
     * 単一の管理ユーザー情報を削除する。
     * @param  \App\Common\Agency\Model\Agency $sample
     * @return void
     * @throws \Throwable
     */
    public function delete(Agency $sample): void;
}
