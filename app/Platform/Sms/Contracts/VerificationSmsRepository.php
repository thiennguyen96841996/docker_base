<?php
namespace GLC\Platform\Sms\Contracts;

use GLC\Platform\Repository\Contracts\ModelRepository;
use GLC\Platform\Sms\Models\VerificationSms;

/**
 * VerificationSmsモデルに関連した処理を行うリポジトリを表すインターフェイス。
 *
 * @package GLC\Platform\Sms\Contracts
 * @author  TinhNC <tinhhang22@gmail.com>
 */
interface VerificationSmsRepository extends ModelRepository
{
    /**
     * 新規データを登録する。
     *
     * @param  string $tel  電話番号
     * @param  string $code 認証用コード
     * @throws \Throwable
     */
    public function store(string $tel, string $code);

    /**
     * 認証コードを更新する。
     *
     * @param  \GLC\Platform\Sms\Models\VerificationSms VerificationSmsオブジェクト
     * @param  string $code 認証用コード
     * @throws \Throwable
     */
    public function updateCode(VerificationSms $model, string $code);
}