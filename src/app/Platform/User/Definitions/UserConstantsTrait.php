<?php
namespace GLC\Platform\User\Definitions;

use Illuminate\Support\Arr;

/**
 * ユーザーに関連した振る舞いを持つトレイト。
 *
 * @package GLC\Platform\User\Definitions
 * @author  Odo Ari <flasanpal@yahoo.co.jp>
 */
trait UserConstantsTrait
{
    /**
     * ID区分コードとその名称の定義配列。
     * @var array
     */
    private static array $roles = [
        self::ROLE_CODE_ADMIN   => self::ROLE_NAME_ADMIN,
        self::ROLE_CODE_SALES   => self::ROLE_NAME_SALES,
        self::ROLE_CODE_CS      => self::ROLE_NAME_CS,
        self::ROLE_CODE_PRODUCT => self::ROLE_NAME_PRODUCT,
        self::ROLE_CODE_AGENT   => self::ROLE_NAME_AGENT,
    ];

    /**
     * 権限と操作可能な機能の定義配列
     * @var array
     */
    private static array $authRole = [
        self::ROLE_CODE_ADMIN => [
            self::AUTH_GROUP_SHOW,
            self::AUTH_GROUP_EXEC,
            self::AUTH_CORPORATION_SHOW,
            self::AUTH_CORPORATION_EXEC,
            self::AUTH_SHOP_SHOW,
            self::AUTH_SHOP_EXEC,
            self::AUTH_EMPLOYEE_SHOW,
            self::AUTH_EMPLOYEE_EXEC,
            self::AUTH_BILL_SHOW,
            self::AUTH_BILL_EXEC,
            self::AUTH_MEISAI_SHOW,
            self::AUTH_MEISAI_CSV,
            self::AUTH_WORK_SHOW,
            self::AUTH_WORK_EXEC,
            self::AUTH_ENTRY_SHOW,
            self::AUTH_ENTRY_EXEC,
            self::AUTH_ENTRY_CSV_PERSONAL,
            self::AUTH_CUSTOMERS_SHOW,
            self::AUTH_CUSTOMERS_EXEC,
            self::AUTH_ID_SHOW,
            self::AUTH_ID_EXEC,
            self::AUTH_CONTENTS_SHOW,
            self::AUTH_TRANSFER_SHOW,
            self::AUTH_PAYMENT_CSV,
            self::AUTH_HONNIN_SHOW,
            self::AUTH_HONNIN_EXEC,
        ],
        self::ROLE_CODE_SALES => [
            self::AUTH_GROUP_SHOW,
            self::AUTH_GROUP_EXEC,
            self::AUTH_CORPORATION_SHOW,
            self::AUTH_CORPORATION_EXEC,
            self::AUTH_SHOP_SHOW,
            self::AUTH_SHOP_EXEC,
            self::AUTH_EMPLOYEE_SHOW,
            self::AUTH_EMPLOYEE_EXEC,
            self::AUTH_BILL_SHOW,
            self::AUTH_BILL_EXEC,
            self::AUTH_MEISAI_SHOW,
            self::AUTH_MEISAI_CSV,
            self::AUTH_WORK_SHOW,
            self::AUTH_WORK_EXEC,
            self::AUTH_ENTRY_SHOW,
            self::AUTH_ENTRY_CSV_PERSONAL,
            self::AUTH_CUSTOMERS_SHOW,
            self::AUTH_ID_SHOW,
            self::AUTH_ID_EXEC,
            self::AUTH_CONTENTS_SHOW,
            self::AUTH_TRANSFER_SHOW,
        ],
        self::ROLE_CODE_CS => [
            self::AUTH_GROUP_SHOW,
            self::AUTH_CORPORATION_SHOW,
            self::AUTH_SHOP_SHOW,
            self::AUTH_EMPLOYEE_SHOW,
            self::AUTH_BILL_SHOW,
            self::AUTH_MEISAI_SHOW,
            self::AUTH_WORK_SHOW,
            self::AUTH_ENTRY_SHOW,
            self::AUTH_CUSTOMERS_SHOW,
            self::AUTH_ID_SHOW,
            self::AUTH_CONTENTS_SHOW,
            self::AUTH_TRANSFER_SHOW,

        ],
        self::ROLE_CODE_PRODUCT => [
            self::AUTH_GROUP_SHOW,
            self::AUTH_CORPORATION_SHOW,
            self::AUTH_SHOP_SHOW,
            self::AUTH_EMPLOYEE_SHOW,
            self::AUTH_BILL_SHOW,
            self::AUTH_MEISAI_SHOW,
            self::AUTH_MEISAI_CSV,
            self::AUTH_WORK_SHOW,
            self::AUTH_ENTRY_SHOW,
            self::AUTH_CUSTOMERS_SHOW,
            self::AUTH_ID_SHOW,
            self::AUTH_CONTENTS_SHOW,
            self::AUTH_TRANSFER_SHOW,
        ],
        self::ROLE_CODE_AGENT => [
            self::AUTH_HONNIN_SHOW,
            self::AUTH_HONNIN_EXEC,
        ],
    ];

    //  機能区分
    public static function getRole($role): array
    {
        return self::$authRole[$role];
    }

    /**
     * ID区分コードとその名称の定義配列を取得する。
     *
     * @return array
     */
    public static function getRoles(): array
    {
        return self::$roles;
    }

    /**
     * ID区分コードに紐づくID区分名称を取得する。
     *
     * @param  string $code ID区分コード
     * @return string
     */
    public static function getRoleCodeName(string $code): string
    {
        return Arr::get(self::$roles, $code, '');
    }
}