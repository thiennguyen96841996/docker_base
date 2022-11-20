<?php
namespace App\Common\Customer\Definition;

/**
 * Gender of customer
 * @package \App\Common\Customer
 */
enum CustomerGender: string
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
            CustomerGender::MALE->value     => 'Nam',
            CustomerGender::FEMALE->value   => 'Nữ',
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
