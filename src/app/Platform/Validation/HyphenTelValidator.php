<?php
namespace GLC\Platform\Validation;

class HyphenTelValidator
{
    /**
     * 電話番号のバリデーションを実行する。
     *
     * @param string $attribute formの属性名
     * @param mixed $value バリデートする値
     * @param array $parameters 拡張パラメーター
     * @return bool バリデーションに適合するかどうか
     */
    public function validateTel($attribute, $value, $parameters): bool
    {
        return preg_match('/\A(0\d{1,3}-\d{1,4}-\d{3,4})\z/u', $value) === 1 && strlen(str_replace('-', '', $value)) >= 10;
    }
}