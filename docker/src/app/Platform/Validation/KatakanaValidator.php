<?php
namespace GLC\Platform\Validation;

/**
 * カタカナのバリデーションを行うカスタムバリデーションクラス。
 *
 * @package GLC\Platform\Validation
 * @author  TinhNC <tinhhang22@gmail.com>
 */
class KatakanaValidator
{
    /**
     * カタカナのバリデーションを実行する。
     *
     * @param  string $attribute formの属性名
     * @param  mixed $value バリデートする値
     * @param  array $parameters 拡張パラメーター
     * @return bool バリデーションに適合するかどうか
     */
    public function validateKatakana($attribute, $value, $parameters): bool
    {
        // 文字列以外の場合はfalseを返却
        if (!is_string($value)) {
            return false;
        }
        return preg_match('/^[ァ-ヴー　]+$/u', $value) === 1;
    }

    /**
     * カタカナのバリデーションを実行する(スペースを許容しない)。
     *
     * @param  string $attribute formの属性名
     * @param  mixed $value バリデートする値
     * @param  array $parameters 拡張パラメーター
     * @return bool バリデーションに適合するかどうか
     */
    public function validateKatakanaNoSpace($attribute, $value, $parameters): bool
    {
        // 文字列以外の場合はfalseを返却
        if (!is_string($value)) {
            return false;
        }
        return preg_match('/^[ァ-ヴー]+$/u', $value) === 1;
    }
}
