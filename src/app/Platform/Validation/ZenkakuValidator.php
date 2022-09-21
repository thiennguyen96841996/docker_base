<?php
namespace GLC\Platform\Validation;

/**
 * 全角のバリデーションを行うカスタムバリデーションクラス。
 *
 * @package GLC\Platform\Validation
 * @author  Mirei Ri <ri.m@tsunagu-grp.jp>
 */
class ZenkakuValidator
{
    /**
     * 全角のバリデーションを実行する。
     *
     * @param  string $attribute formの属性名
     * @param  mixed $value バリデートする値
     * @param  array $parameters 拡張パラメーター
     * @return bool バリデーションに適合するかどうか
     */
    public function validateZenkaku($attribute, $value, $parameters): bool
    {
        // 文字列以外の場合はfalseを返却
        if (!is_string($value)) {
            return false;
        }
        return preg_match('/^[ぁ-んァ-ヶ・ー一-龠]+$/u', $value) === 1;
    }
}
