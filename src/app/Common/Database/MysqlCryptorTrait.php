<?php
namespace App\Common\Database;

/**
 * コノヒニの暗号化キーで暗号化する場合の共通関数。
 *
 * @package App\Common\Database
 */
trait MysqlCryptorTrait
{
    /**
     * データを暗号化する。
     *
     * @param  string $value 暗号化したいデータ
     * @return string 暗号化されたデータ
     */
    public function encrypt(string $value): string
    {
        return (new MysqlCryptor())->encrypt($value, config('app.encrypt_key'));
    }

    /**
     * 暗号化されたデータを復号する。
     *
     * @param  string $encrypted 暗号化された文字列
     * @return bool|string 復号された文字列 or false
     */
    public function decrypt(string $encrypted): bool | string
    {
        return (new MysqlCryptor())->decrypt($encrypted, config('app.encrypt_key'));
    }
}
