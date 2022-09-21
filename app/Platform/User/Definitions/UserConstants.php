<?php
namespace GLC\Platform\User\Definitions;

/**
 * ユーザーに関連した定義を持つインターフェース。
 *
 * @package GLC\Platform\User\Definitions
 * @author  Odo Ari <flasanpal@yahoo.co.jp>
 */
interface UserConstants
{
//=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
//  ID区分
//=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    // コード
    const ROLE_CODE_ADMIN   = '01';
    const ROLE_CODE_SALES   = '02';
    const ROLE_CODE_CS      = '03';
    const ROLE_CODE_PRODUCT = '04';
    const ROLE_CODE_AGENT   = '05';
    // 名称
    const ROLE_NAME_ADMIN   = '責任者';
    const ROLE_NAME_SALES   = '営業統括';
    const ROLE_NAME_CS      = 'CS';
    const ROLE_NAME_PRODUCT = '一般(営業、開発・制作・企画、経理)';
    const ROLE_NAME_AGENT   = '委託';

//=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
//  機能区分:
//=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    const FUNCTION_CODE_LOGIN           = '00'; // ログイン
    const FUNCTION_CODE_GROUP           = '01'; // グループ
    const FUNCTION_CODE_CORPORATION     = '02'; // 法人
    const FUNCTION_CODE_SHOP            = '03'; // 事業所
    const FUNCTION_CODE_EMPLOYEE        = '04'; // 担当者
    const FUNCTION_CODE_BILL            = '05'; // 請求書
    const FUNCTION_CODE_MEISAI          = '06'; // 利用明細
    const FUNCTION_CODE_WORK            = '07'; // ワーク
    const FUNCTION_CODE_ENTRY           = '08'; // エントリー
    const FUNCTION_CODE_CUSTOMERS       = '09'; // カスタマー
    const FUNCTION_CODE_ID              = '10'; // ID
    const FUNCTION_CODE_CONTENTS        = '11'; // 任意項目
    const FUNCTION_CODE_TRANSFER        = '12'; // 振り込み
    const FUNCTION_CODE_HONNIN          = '13'; // 本人確認
    const FUNCTION_CODE_PAYMENT         = '14'; // 支払い実績

    const ACTION_CODE_SHOW              = '00'; // 閲覧
    const ACTION_CODE_EXEC              = '01'; // 操作
    const ACTION_CODE_CSV               = '02'; // CSV
    const ACTION_CODE_CSV_PERSONAL      = '03'; // CSV(個人参照用)

    const AUTH_GROUP_SHOW          = self::FUNCTION_CODE_GROUP.       self::ACTION_CODE_SHOW;
    const AUTH_GROUP_EXEC          = self::FUNCTION_CODE_GROUP.       self::ACTION_CODE_EXEC;
    const AUTH_CORPORATION_SHOW    = self::FUNCTION_CODE_CORPORATION. self::ACTION_CODE_SHOW;
    const AUTH_CORPORATION_EXEC    = self::FUNCTION_CODE_CORPORATION. self::ACTION_CODE_EXEC;
    const AUTH_SHOP_SHOW           = self::FUNCTION_CODE_SHOP.        self::ACTION_CODE_SHOW;
    const AUTH_SHOP_EXEC           = self::FUNCTION_CODE_SHOP.        self::ACTION_CODE_EXEC;
    const AUTH_EMPLOYEE_SHOW       = self::FUNCTION_CODE_EMPLOYEE.    self::ACTION_CODE_SHOW;
    const AUTH_EMPLOYEE_EXEC       = self::FUNCTION_CODE_EMPLOYEE.    self::ACTION_CODE_EXEC;
    const AUTH_BILL_SHOW           = self::FUNCTION_CODE_BILL.        self::ACTION_CODE_SHOW;
    const AUTH_BILL_EXEC           = self::FUNCTION_CODE_BILL.        self::ACTION_CODE_EXEC;
    const AUTH_MEISAI_SHOW         = self::FUNCTION_CODE_MEISAI.      self::ACTION_CODE_SHOW;
    const AUTH_MEISAI_CSV          = self::FUNCTION_CODE_MEISAI.      self::ACTION_CODE_CSV;
    const AUTH_MEISAI_EXEC         = self::FUNCTION_CODE_MEISAI.      self::ACTION_CODE_EXEC;
    const AUTH_WORK_SHOW           = self::FUNCTION_CODE_WORK.        self::ACTION_CODE_SHOW;
    const AUTH_WORK_EXEC           = self::FUNCTION_CODE_WORK.        self::ACTION_CODE_EXEC;
    const AUTH_ENTRY_SHOW          = self::FUNCTION_CODE_ENTRY.       self::ACTION_CODE_SHOW;
    const AUTH_ENTRY_EXEC          = self::FUNCTION_CODE_ENTRY.       self::ACTION_CODE_EXEC;
    const AUTH_ENTRY_CSV_PERSONAL  = self::FUNCTION_CODE_ENTRY.       self::ACTION_CODE_CSV_PERSONAL;
    const AUTH_CUSTOMERS_SHOW      = self::FUNCTION_CODE_CUSTOMERS.   self::ACTION_CODE_SHOW;
    const AUTH_CUSTOMERS_EXEC      = self::FUNCTION_CODE_CUSTOMERS.   self::ACTION_CODE_EXEC;
    const AUTH_ID_SHOW             = self::FUNCTION_CODE_ID.          self::ACTION_CODE_SHOW;
    const AUTH_ID_EXEC             = self::FUNCTION_CODE_ID.          self::ACTION_CODE_EXEC;
    const AUTH_CONTENTS_SHOW       = self::FUNCTION_CODE_CONTENTS.    self::ACTION_CODE_SHOW;
    const AUTH_CONTENTS_EXEC       = self::FUNCTION_CODE_CONTENTS.    self::ACTION_CODE_EXEC;
    const AUTH_TRANSFER_SHOW       = self::FUNCTION_CODE_TRANSFER.    self::ACTION_CODE_SHOW;
    const AUTH_TRANSFER_EXEC       = self::FUNCTION_CODE_TRANSFER.    self::ACTION_CODE_EXEC;
    const AUTH_PAYMENT_CSV         = self::FUNCTION_CODE_PAYMENT.     self::ACTION_CODE_CSV;
    const AUTH_HONNIN_SHOW         = self::FUNCTION_CODE_HONNIN.      self::ACTION_CODE_SHOW;
    const AUTH_HONNIN_EXEC         = self::FUNCTION_CODE_HONNIN.      self::ACTION_CODE_EXEC;


}