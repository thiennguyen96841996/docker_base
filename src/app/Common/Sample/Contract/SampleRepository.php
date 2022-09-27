<?php
namespace App\Common\Sample\Contract;

use App\Common\Sample\Model\Sample;
use App\Common\Database\Contract\ModelRepository;

/**
 * Sampleモデルのデータ操作を扱うクラスを表すインターフェイス。
 * @package \App\Common\Sample
 */
interface SampleRepository extends ModelRepository
{
    /**
     * 単一の管理ユーザー情報を登録する。
     * @param  array<string, mixed> $params
     * @return \App\Common\Sample\Model\Sample
     * @throws \Throwable
     */
    public function store(array $params): Sample;

    /**
     * 単一の管理ユーザー情報を更新する。
     * @param  array<string, mixed> $params
     * @param  \App\Common\Sample\Model\Sample $sample
     * @return void
     * @throws \Throwable
     */
    public function update(Sample $Sample, array $params): void;

    /**
     * 単一の管理ユーザー情報を削除する。
     * @param  \App\Common\Sample\Model\Sample $sample
     * @return void
     * @throws \Throwable
     */
    public function delete(Sample $sample): void;

    /**
     * 最終ログイン日時を更新する。
     * ※ ログインにはメールアドレスを使用していて、ユニーク制約もあるのでIDに変換して検索はしていない。
     * @param  string $email
     * @return void
     */
    public function updateLastLoginDate(string $email): void;
}
