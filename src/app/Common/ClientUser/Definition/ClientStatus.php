<?php
namespace App\Common\ClientUser\Definition;

/**
 * 利用状態を表す列挙型。
 * @package \App\Common\ClientUser
 */
enum ClientStatus: string
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
            ClientStatus::ACTIVE->value     => 'Đang hoạt động',
            ClientStatus::INACTIVE->value   => 'Ngừng hoạt động',
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
