<?php
namespace App\Common\AgencyContract\Definition;

/**
 * 利用状態AgencyContractを表す列挙型。
 * @package \App\Common\AgencyContract\Definition;
 */
enum AgencyContract: int
{
    case MONTH_1    = 1;
    case MONTH_2    = 2;
    case MONTH_3    = 3;
    case MONTH_4    = 4;
    case MONTH_5    = 5;
    case MONTH_6    = 6;
    case MONTH_7    = 7;
    case MONTH_8    = 8;
    case MONTH_9    = 9;
    case MONTH_10   = 10;
    case MONTH_11   = 11;
    case MONTH_12   = 12;
    case MONTH_13   = 13;
    case MONTH_14   = 14;
    case MONTH_15   = 15;
    case MONTH_16   = 16;
    case MONTH_17   = 17;
    case MONTH_18   = 18;
    case MONTH_19   = 19;
    case MONTH_20   = 20;
    case MONTH_21   = 21;
    case MONTH_22   = 22;
    case MONTH_23   = 23;
    case MONTH_24   = 24;
    case MONTH_25   = 25;
    case MONTH_26   = 26;
    case MONTH_27   = 27;
    case MONTH_28   = 28;
    case MONTH_29   = 29;
    case MONTH_30   = 30;
    case MONTH_31   = 31;
    case MONTH_32   = 32;
    case MONTH_33   = 33;
    case MONTH_34   = 34;
    case MONTH_35   = 35;
    case MONTH_36   = 36;
    case UN_LIMIT   = 37;


    /**
     * 定義値に対応した名称を取得する。
     * @param  int $value
     * @return string
     */
    public static function getName(int $value): string
    {
        return match ($value) {
            AgencyContract::MONTH_1->value  => '1 tháng',
            AgencyContract::MONTH_2->value  => '2 tháng',
            AgencyContract::MONTH_3->value  => '3 tháng',
            AgencyContract::MONTH_4->value  => '4 tháng',
            AgencyContract::MONTH_5->value  => '5 tháng',
            AgencyContract::MONTH_6->value  => '6 tháng',
            AgencyContract::MONTH_7->value  => '7 tháng',
            AgencyContract::MONTH_8->value  => '8 tháng',
            AgencyContract::MONTH_9->value  => '9 tháng',
            AgencyContract::MONTH_10->value => '10 tháng',
            AgencyContract::MONTH_11->value => '11 tháng',
            AgencyContract::MONTH_12->value => '12 tháng',
            AgencyContract::MONTH_13->value => '13 tháng',
            AgencyContract::MONTH_14->value => '14 tháng',
            AgencyContract::MONTH_15->value => '15 tháng',
            AgencyContract::MONTH_16->value => '16 tháng',
            AgencyContract::MONTH_17->value => '17 tháng',
            AgencyContract::MONTH_18->value => '18 tháng',
            AgencyContract::MONTH_19->value => '19 tháng',
            AgencyContract::MONTH_20->value => '20 tháng',
            AgencyContract::MONTH_21->value => '21 tháng',
            AgencyContract::MONTH_22->value => '22 tháng',
            AgencyContract::MONTH_23->value => '23 tháng',
            AgencyContract::MONTH_24->value => '24 tháng',
            AgencyContract::MONTH_25->value => '25 tháng',
            AgencyContract::MONTH_26->value => '26 tháng',
            AgencyContract::MONTH_27->value => '27 tháng',
            AgencyContract::MONTH_28->value => '28 tháng',
            AgencyContract::MONTH_29->value => '29 tháng',
            AgencyContract::MONTH_30->value => '30 tháng',
            AgencyContract::MONTH_31->value => '31 tháng',
            AgencyContract::MONTH_32->value => '32 tháng',
            AgencyContract::MONTH_33->value => '33 tháng',
            AgencyContract::MONTH_34->value => '34 tháng',
            AgencyContract::MONTH_35->value => '35 tháng',
            AgencyContract::MONTH_36->value => '36 tháng',
            AgencyContract::UN_LIMIT->value => 'Không giới hạn'
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
