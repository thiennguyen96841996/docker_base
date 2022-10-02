<?php
namespace App\Common\Validation;

/**
 * 電話番号のバリデーションを行うカスタムバリデーションクラス。
 *
 * @package App\Common\Validation
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
    public function validateTel(string $attribute, mixed $value, array $parameters): bool
    {
        return preg_match('/\A[0-9]{2,4}-?[0-9]{1,4}-?[0-9]{3,4}\z/u', $value) === 1 && strlen(str_replace('-', '', $value)) == 10;
    }
}
