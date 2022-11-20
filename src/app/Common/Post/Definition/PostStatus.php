<?php

namespace App\Common\Post\Definition;

/**
 * status definition
 * @package \App\Common\Post
 */
enum PostStatus: string
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
            PostStatus::INIT->value     => 'Mặc định',
            PostStatus::PUBLIC->value   => 'Công khai',
            PostStatus::PRIVATE->value  => 'Riêng tư',
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
