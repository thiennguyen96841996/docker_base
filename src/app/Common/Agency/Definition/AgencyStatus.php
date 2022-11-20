<?php
namespace App\Common\Agency\Definition;

/**
 * 利用状態Agencyを表す列挙型。
 * @package \App\Common\Agency\Definition;
 */
enum AgencyStatus: string
{
    /** 利用中 */
    case ACTIVE = '01';

    /** 利用停止 */
    case INACTIVE = '02';

    /**
     * 定義値に対応した名称を取得する。
     * @param  string $value
     * @return string
     */
    public static function getName(string $value): string
    {
        return match ($value) {
            AgencyStatus::ACTIVE->value     => 'Đang hoạt động',
            AgencyStatus::INACTIVE->value   => 'Ngừng hoạt động',
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
