<?php
namespace App\Common\Database\Definition;

/**
 * Gender of customer
 * @package \App\Common\Database
 */
enum Gender: string
{
    /** man */
    case MALE = '01';

    /** woman */
    case FEMALE = '02';

    /**
     * get gender's name
     * @param  string $value
     * @return string
     */
    public static function getName(string $value): string
    {
        return match ($value) {
            Gender::MALE->value     => 'Nam',
            Gender::FEMALE->value   => 'Nữ',
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
