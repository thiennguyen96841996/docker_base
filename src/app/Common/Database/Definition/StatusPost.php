<?php

namespace App\Common\Database\Definition;

/**
 * status definition
 * @package \App\Common\Database
 */
enum StatusPost: string
{
    /** init */
    case INIT = '00';

    /** public */
    case PUBLIC = '01';

    /** private */
    case PRIVATE = '02';

    /**
     * get status's name
     * @param  string $value
     * @return string
     */
    public static function getName(string $value): string
    {
        return match ($value) {
            Status::INIT->value   => 'Mặc định',
            Status::PUBLIC->value   => 'Công khai',
            Status::PRIVATE->value   => 'Riêng tư',
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
