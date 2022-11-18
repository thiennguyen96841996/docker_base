<?php

namespace Database\Seeders\Partial;

use App\Common\Agency\Model\Agency;
use Illuminate\Database\Seeder;
use App\Common\Database\Definition\DatabaseDefs;
use App\Common\Database\MysqlCryptorTrait;

/**
 * Agencyモデルの初期データを登録するクラス。
 * @package \Database\Seeders
 */
class AgencySeeder extends Seeder
{
    use MysqlCryptorTrait;
    /**
     * 初期データを登録する。
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name'         => 'Agency Name',
                'tel'          => '0900000001',
                'address'      => '東京都板橋区高島平2-26-1-811',
                'status'      => '01',
                'agency_director'      => 'Lee Syn',
                'establishment_date'      => '2020-04-01 00:00:00',
            ],
            [
                'name'         => 'BẤT ĐỘNG SẢN HÀ NỘI',
                'tel'          => '090000' . rand(1000, 9999),
                'address'      => '0011 PHAN KẾ BÍNH, PHƯỜNG CỐNG VỊ, QUẬN BA ĐÌNH, HÀ NỘI',
                'status'      => '02',
            ],
            [
                'name'         => 'BẤT ĐỘNG SẢN MỄ TRÌ',
                'tel'          => '090000' . rand(1000, 9999),
                'address'      => '900 MỄ TRÌ THƯỢNG, PHƯỜNG MỄ TRÌ, QUẬN NAM TỪ NIÊM, HÀ NỘI',
                'status'      => '01',
            ],
            [
                'name'         => 'BẤT ĐỘNG SẢN THÀNH CÔNG',
                'tel'          => '090000' . rand(1000, 9999),
                'address'      => '9 Giải Phóng, Tỉnh Hà Giang',
                'status'      => '01',
            ],
            [
                'name'         => 'BẤT ĐỘNG SẢN CHU LAI',
                'tel'          => '090000' . rand(1000, 9999),
                'address'      => '09 TRẦN DUY HƯNG, TRUNG HOÀ, CẦU GIẤY, HÀ NỘI',
                'status'      => '02',
            ],
            [
                'name'         => 'BẤT ĐỘNG SẢN PHAN TRÌNH GIAI CÔNG',
                'tel'          => '090000' . rand(1000, 9999),
                'address'      => 'NHÀ A5, LÀNG QUỐC TẾ THĂNG LONG, PHƯỜNG DỊCH VỌNG, QUẬN CẦU GIẤY, THÀNH PHỐ HÀ NỘI',
                'status'      => '01',
            ],
            [
                'name'         => 'Kon tum',
                'tel'          => '090000' . rand(1000, 9999),
                'address'      => 'KON TUM',
                'status'      => '02',
                'establishment_date'      => '2021-12-12 00:00:00',
            ],
            [
                'name'         => 'Bất Động Sản Hưng Hà',
                'tel'          => '090000' . rand(1000, 9999),
                'address'      => '10 GIA LONG',
                'status'      => '01',
            ],
            [
                'name'         => 'bái triều',
                'tel'          => '090000' . rand(1000, 9999),
                'address'      => 'thành phố hạ long',
                'status'      => '01',
            ],
            [
                'name'         => 'BẤT ĐỘNG SẢN THÀNH PHỐ HỒ CHÍ MINH',
                'tel'          => '090000' . rand(1000, 9999),
                'address'      => '25/65/66 Nguyễn Bỉnh Khiêm, Phường Bến Nghé, Quận 1, TP Hồ Chí Minh',
                'status'      => '01',
            ],
        ];

        for ($i = 1; $i <= 1000; $i++) {
            foreach ($data as $item) {
                $agency = new Agency();
                $agency->setConnection(DatabaseDefs::CONNECTION_NAME_MIGRATION);
                /** @var \Illuminate\Database\Eloquent\Builder $agency */
                $agency->fill($item)->save();
            }
        }
    }
}
