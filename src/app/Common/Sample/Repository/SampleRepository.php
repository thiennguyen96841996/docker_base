<?php
namespace App\Common\Sample\Repository;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Common\Sample\Contract\SampleRepository as SampleRepositoryContract;
use App\Common\Sample\Model\Sample;
use App\Common\Database\Definition\DatabaseDefs;
use App\Common\Database\RepositoryConnection;

/**
 * Sampleモデルのデータ操作を扱うクラス。
 * @package \App\Common\Sample
 */
class SampleRepository implements SampleRepositoryContract
{
    use RepositoryConnection;

    /**
     * 検索条件に合致したデータを持つSampleモデルのコレクションを取得する。
     * @param  array<string, mixed> $searchConditions
     * @param  array<string, mixed> $selectColumns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function fetchAll(array $searchConditions, array $selectColumns = ['*']): Collection
    {
        return $this->makeBasicBuilder($searchConditions, $selectColumns)->get();
    }

    /**
     * 検索条件に合致したデータを持つSampleモデルをページネーターとして取得する。
     * @param  array<string, mixed> $searchConditions
     * @param  array<string, mixed> $selectColumns
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function fetchAsPaginator(array $searchConditions, array $selectColumns = ['*']): LengthAwarePaginator
    {
        return $this->makeBasicBuilder($searchConditions, $selectColumns)->paginate();
    }

    /**
     * 検索条件に合致した単一のSampleモデルを取得する。
     * @param  array<string, mixed> $searchConditions
     * @param  array<string, mixed> $selectColumns
     * @return \App\Common\Sample\Model\Sample
     * @throws \Throwable
     * @noinspection PhpIncompatibleReturnTypeInspection
     */
    public function fetchOne(array $searchConditions, array $selectColumns = ['*']): Sample
    {
        return $this->makeBasicBuilder($searchConditions, $selectColumns)->firstOrFail();
    }

    /**
     * 単一の管理ユーザー情報を登録する。
     * @param  array<string, mixed> $params
     * @return \App\Common\Sample\Model\Sample
     * @throws \Throwable
     */
    public function store(array $params): Sample
    {
        $sample = new Sample();
        $sample->setConnection(DatabaseDefs::CONNECTION_NAME_WRITE);
        $sample->fill($params)->save();

        return $sample;
    }

    /**
     * 単一の管理ユーザー情報を更新する。
     * @param  array<string, mixed> $params
     * @param  \App\Common\Sample\Model\Sample $sample
     * @return void
     * @throws \Throwable
     */
    public function update(Sample $sample, array $params): void
    {
        $sample->setConnection(DatabaseDefs::CONNECTION_NAME_WRITE);
        $sample->update($params);
    }

    /**
     * 単一の管理ユーザー情報を削除する。
     * @param  \App\Common\Sample\Model\Sample $Sample
     * @return void
     * @throws \Throwable
     */
    public function delete(Sample $sample): void
    {
        $sample->setConnection(DatabaseDefs::CONNECTION_NAME_WRITE);
        $sample->delete();
    }

    /**
     * 最終ログイン日時を更新する。
     * ※ ログインにはメールアドレスを使用していて、ユニーク制約もあるのでIDに変換して検索はしていない。
     * @param  string $email
     * @return void
     */
    public function updateLastLoginDate(string $email): void
    {
        $clientUser = $this->makeBasicBuilder([ 'email' => $email ])->firstOrFail();
        $clientUser->setAttribute('last_login_at', Carbon::now());

        $clientUser->timestamps = false; // updated_atは更新しない
        $clientUser->setConnection(DatabaseDefs::CONNECTION_NAME_WRITE)->save();
        $clientUser->timestamps = true;
    }

    /**
     * 標準的な設定をしたビルダーを作成する。
     * @param  array $searchConditions
     * @param  array $selectColumns
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function makeBasicBuilder(array $searchConditions, array $selectColumns = ['*']): Builder
    {
        /** @var \App\Common\Sample\Model\Sample $builder */
        $builder = Sample::on($this->getConnection(DatabaseDefs::CONNECTION_NAME_READ))
            ->addSelect($selectColumns);

        return $builder->whereMultiConditions($searchConditions);
    }
}
