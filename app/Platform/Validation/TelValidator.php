<?php
namespace GLC\Platform\Validation;

/**
 * 電話番号のバリデーションを行うカスタムバリデーションクラス。
 *
 * @package GLC\Platform\Validation
 * @author  TinhNC <tinhhang22@gmail.com>
 */
class TelValidator
{
    /**
     * 電話番号のバリデーションを実行する。
     *
     * @param  string $attribute formの属性名
     * @param  mixed $value バリデートする値
     * @param  array $parameters 拡張パラメーター
     * @return bool バリデーションに適合するかどうか
     */
    public function validateTel($attribute, $value, $parameters): bool
    {
        return preg_match('/\A[0-9]{2,4}-?[0-9]{1,4}-?[0-9]{3,4}\z/u', $value) === 1 && strlen(str_replace('-', '', $value)) >= 10;
    }
}
