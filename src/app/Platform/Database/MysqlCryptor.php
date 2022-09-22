<?php
namespace GLC\Platform\Database;

/**
 * Mysqlの暗号化に合わせた方式でデータを暗号化するためのクラス。
 *
 * @package GLC\Platform\Database
 * @author  TinhNC <tinhhang22@gmail.com>
 */
class MysqlCryptor
{
    /**
     * 暗号化方式の定義。
     * @var string
     */
    private string $method = 'aes-128-ecb';

    /**
     * データを暗号化する。
     *
     * @param  string $value 暗号化したいデータ
     * @param  string $password 暗号化に使用する元パスワード
     * @return string 暗号化されたデータ
     */
    public function encrypt(string $value, string $password): string
    {
        $blockSize = 16;

        /*
         * 暗号化のキーを作成する。
         *
         * ブロックサイズに収まっている間は基本的に$passwordの値と同じものになる。
         * ex)
         *   $password = password(8文字)
         *       => $key = password
         *
         *   $password = passwordpassword(16文字)
         *       => $key = passwordpassword
         *
         * ブロックサイズを超えると空文字ではなく前に入れられた文字との比較になるので変化し始める。
         * ord($key[$i%$blockSize])の値が最初の16文字までは$keyの定義通りで0であるが、
         * 2周目に入ると前回代入された文字があるのでその文字によって0ではない値が入る。
         * 結果的にord($key[$i%$blockSize])) ^ old($password[$i])の計算結果が変動するので単純な同じ文字列ではなくなる。
         */
        $key = "\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0";
        for ($i = 0; $i < strlen($password); $i++) {
            $key[$i%$blockSize] = chr(ord($key[$i%$blockSize]) ^ ord($password[$i]));
        }

        // パディング処理を行う。
        // $padの数値によって穴埋めに使う文字列は変わる。
        $pad   = $blockSize - (strlen($value) % $blockSize);
        $value = $value . str_repeat(chr($pad), $pad);

        return strtoupper(
            bin2hex(
                openssl_encrypt(
                    $value,
                    $this->method,
                    $key,
                    OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING,
                )
            )
        );
    }

    /**
     * 暗号化されたデータを復号する。
     *
     * @param  string $encrypted 暗号化された文字列
     * @param  string $password 暗号化の際に使用した元パスワード
     * @return bool|string 復号された文字列 or false
     */
    public function decrypt(string $encrypted, string $password): bool | string
    {
        // ※ encryptを逆の手順で複合しているので詳しくはencrypt関数のコメントを参照のこと。

        $blockSize = 16;
        $key = "\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0";

        for ($i = 0; $i < strlen($password); $i++) {
            $key[$i%$blockSize] = chr(ord($key[$i%$blockSize]) ^ ord($password[$i]));
        }

        $decrypted = openssl_decrypt(
            hex2bin($encrypted),
            $this->method,
            $key,
            OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING,
        );

        $pad = ord($decrypted [strlen($decrypted) - 1]);
        if ($pad > strlen($decrypted)
            || strspn($decrypted, chr($pad), strlen($decrypted) - $pad) != $pad) {
            return false;
        }
        return substr($decrypted, 0, strpos($decrypted, chr($pad)));
    }
}
