<?php
namespace GLC\Platform\Sms\Repositories;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use GLC\Platform\Database\Definitions\DatabaseDefs;
use GLC\Platform\Database\MysqlCryptor;
use GLC\Platform\Sms\Contracts\VerificationSmsRepository as RepositoryContract;
use GLC\Platform\Sms\Models\VerificationSms;

/**
 * VerificationSmsモデルに関連した処理を行うリポジトリ。
 *
 * @package GLC\Platform\Sms\Repositories
 * @author  TinhNC <tinhhang22@gmail.com>
 */
class VerificationSmsRepository implements RepositoryContract
{
    /**
     * 検索条件に合致したデータを取得して返す。
     *
     * @param array $searchConditions 検索条件の配列
     * @param bool $writeConnection
     * @return \Illuminate\Support\Collection|null VerificationSmsのCollectionオブジェクト or null
     */
    public function getCollection(array $searchConditions, bool $writeConnection = false): ?Collection
    {
        if ($writeConnection) {
            $builder = VerificationSms::on(DatabaseDefs::CONNECTION_NAME_WRITE_SECURE);
        } else {
            $builder = VerificationSms::on(DatabaseDefs::CONNECTION_NAME_READ_SECURE);
        }

        /** @var \GLC\Platform\Sms\Models\VerificationSms $builder */
        $builder
            ->addSelect([
                '*'
            ]);

        return $builder->whereMultiConditions($searchConditions)->get();
    }

    /**
     * 検索条件に合致した単一のデータを取得して返す。
     *
     * @param array $searchConditions 検索条件の配列
     * @param bool $writeConnection
     * @return \GLC\Platform\Sms\Models\VerificationSms|null VerificationSmsオブジェクト or null
     */
    public function getModel(array $searchConditions, bool $writeConnection = false): ?VerificationSms
    {
        $collection = $this->getCollection($searchConditions, $writeConnection);

        return $collection->count() === 1 ? $collection->first(): null;
    }

    /**
     * 新規データを登録する。
     *
     * @param  string $tel  電話番号
     * @param  string $code 認証用コード
     * @throws \Throwable
     */
    public function store(string $tel, string $code)
    {
        DB::connection(DatabaseDefs::CONNECTION_NAME_WRITE_SECURE)->transaction(function () use($tel, $code) {
            $sms = new VerificationSms();
            $sms->tel  = (new MysqlCryptor())->encrypt($tel, config('app.encrypt_key'));
            $sms->code = $code;
            $sms->setConnection(DatabaseDefs::CONNECTION_NAME_WRITE_SECURE)->save();
        });
    }

    /**
     * 認証コードを更新する。
     *
     * @param  \GLC\Platform\Sms\Models\VerificationSms VerificationSmsオブジェクト
     * @param  string $code 認証用コード
     * @throws \Throwable
     */
    public function updateCode(VerificationSms $model, string $code)
    {
        DB::connection(DatabaseDefs::CONNECTION_NAME_WRITE_SECURE)->transaction(function () use($model, $code) {
            $model->code = $code;
            $model->setConnection(DatabaseDefs::CONNECTION_NAME_WRITE_SECURE)->save();
        });

    }
}