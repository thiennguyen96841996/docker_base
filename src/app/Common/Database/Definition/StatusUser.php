<?php

namespace App\Common\Database\Definition;

/**
 * status definition
 * @package \App\Common\Database
 */
enum StatusUser: string
{
    /** active */
    case ACTIVE = '01';
    /** inactive */
    case INACTIVE = '02';

    /**
     * get status's name
     * @param  string $value
     * @return string
     */
    public static function getName(string $value): string
    {
        return match ($value) {
            Status::ACTIVE->value     => 'Đang hoạt động',
            Status::INACTIVE->value   => 'Ngừng hoạt động',
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
