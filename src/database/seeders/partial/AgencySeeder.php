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
                'tel'          => '090000000001',
                'address'      => '東京都板橋区高島平2-26-1-811',
            ],
            [
                'name'         => 'BẤT ĐỘNG SẢN HÀ NỘI',
                'tel'          => '0900000' . rand(1000, 9999),
                'address'      => '0011 PHAN KẾ BÍNH, PHƯỜNG CỐNG VỊ, QUẬN BA ĐÌNH, HÀ NỘI',
            ],
            [
                'name'         => 'BẤT ĐỘNG SẢN MỄ TRÌ',
                'tel'          => '0900000' . rand(1000, 9999),
                'address'      => '900 MỄ TRÌ THƯỢNG, PHƯỜNG MỄ TRÌ, QUẬN NAM TỪ NIÊM, HÀ NỘI',
            ],
            [
                'name'         => 'BẤT ĐỘNG SẢN THÀNH CÔNG',
                'tel'          => '0900000' . rand(1000, 9999),
                'address'      => '9 Giải Phóng, Tỉnh Hà Giang',
            ],
            [
                'name'         => 'BẤT ĐỘNG SẢN CHU LAI',
                'tel'          => '0900000' . rand(1000, 9999),
                'address'      => '09 TRẦN DUY HƯNG, TRUNG HOÀ, CẦU GIẤY, HÀ NỘI',
            ],
            [
                'name'         => 'BẤT ĐỘNG SẢN PHAN TRÌNH GIAI CÔNG',
                'tel'          => '0900000' . rand(1000, 9999),
                'address'      => 'NHÀ A5, LÀNG QUỐC TẾ THĂNG LONG, PHƯỜNG DỊCH VỌNG, QUẬN CẦU GIẤY, THÀNH PHỐ HÀ NỘI',
            ],
            [
                'name'         => 'Kon tum',
                'tel'          => '0900000' . rand(1000, 9999),
                'address'      => 'KON TUM',
            ],
            [
                'name'         => 'Bất Động Sản Hưng Hà',
                'tel'          => '0900000' . rand(1000, 9999),
                'address'      => '10 GIA LONG',
            ],
            [
                'name'         => 'bái triều',
                'tel'          => '0900000' . rand(1000, 9999),
                'address'      => 'thành phố hạ long',
            ],
            [
                'name'         => 'BẤT ĐỘNG SẢN THÀNH PHỐ HỒ CHÍ MINH',
                'tel'          => '0900000' . rand(1000, 9999),
                'address'      => '25/65/66 Nguyễn Bỉnh Khiêm, Phường Bến Nghé, Quận 1, TP Hồ Chí Minh',
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
