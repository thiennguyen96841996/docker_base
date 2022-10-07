<?php
namespace App\Common\Database\Definition;

/**
 * 利用状態を表す列挙型。
 * @package \App\Common\Database
 */
enum AvailableStatus: string
{
    /** 利用中 */
    case AVAILABLE = '01';

    /** 利用停止 */
    case NOT_AVAILABLE = '02';

    /**
     * 定義値に対応した名称を取得する。
     * @param  string $value
     * @return string
     */
    public static function getName(string $value): string
    {
        return match ($value) {
            AvailableStatus::AVAILABLE->value     => 'Available',
            AvailableStatus::NOT_AVAILABLE->value => 'Unavailable',
        };
    }

    /**
     * 定義値の値を配列で取得する。
     * @return array
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
