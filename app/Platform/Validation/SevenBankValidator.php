<?php
namespace GLC\Platform\Validation;

class SevenBankValidator
{
    /**
     * 口座名義などをチェック
     * 半角データ or 全角カナ
     * @param $attribute
     * @param $value
     * @param $parameters
     * @return int
     */
    public function validateSevenBank($attribute, $value, $parameters)
    {
        $regexSevenBank = '/^[A-Z0-9ｱ-ﾝｦﾞﾟ\-\/.,\(\)｢｣\\\\ ]+$/u';
        return preg_match($regexSevenBank, $value);
    }
}
