<?php
namespace GLC\Platform\Validation;

/**
 * パスワードのバリデーションを行うカスタムバリデーションクラス。
 *
 * @package GLC\Platform\Validation
 * @author  TinhNC <tinhhang22@gmail.com>
 */
class PasswordValidator
{
    /**
     * パスワードのバリデーションを実行する。
     * ※条件は半角のアルファベット・数字・記号をそれぞれ1種類以上含む8文字以上16文字以下の文字列。
     *
     * @param  string $attribute formの属性名
     * @param  mixed $value バリデートする値
     * @param  array $parameters 拡張パラメーター
     * @return bool バリデーションに適合するかどうか
     */
    public function validatePassword($attribute, $value, $parameters)
    {
        // 参考URL
        // http://qiita.com/mpyw/items/886218e7b418dfed254b
        return preg_match('/\A(?=.*?[a-z])(?=.*?\d)(?=.*?[!-\/:-@[-`{-~])[!-~]{8,16}+\z/i', $value) === 1;
    }
}
