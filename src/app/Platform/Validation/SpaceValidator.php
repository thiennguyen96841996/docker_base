<?php
namespace GLC\Platform\Validation;

/**
 * スペースのバリデーションを行うカスタムバリデーションクラス。
 *
 * @package GLC\Platform\Validation
 * @author
 */
class SpaceValidator
{
    /**
     * 制御文字のバリデーションを実行する。
     *
     * @param  string $attribute formの属性名
     * @param  mixed $value バリデートする値
     * @param  array $parameters 拡張パラメーター
     * @return bool バリデーションに適合するかどうか
     */
    public function validateNoSpace($attribute, $value, $parameters): bool
    {
        // 文字列以外の場合はfalseを返却
        if (!is_string($value)) {
            return false;
        }
        return preg_match("/( |　)/", $value) === 0;
    }
}