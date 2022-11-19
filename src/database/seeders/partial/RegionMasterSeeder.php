<?php

namespace Database\Seeders\Partial;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Common\Database\Definition\DatabaseDefs;
use App\Common\RegionMaster\Model\RegionMaster;

/**
 * RegionMasterSeederモデルの初期データを登録するクラス。
 * @package \Database\Seeders
 */
class RegionMasterSeeder extends Seeder
{
    /**
     * 初期データを登録する。
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'region_code'         => '90000',
                'region_name'         => 'An Giang',
            ],
            [
                'region_code'         => '74000',
                'region_name'         => 'TP. Hồ Chí Minh',
            ],
            [
                'region_code'         => '10000',
                'region_name'         => 'Hà Nội',
            ],
            [
                'region_code'         => '60000',
                'region_name'         => 'Thái Bình',
            ],
            [
                'region_code'         => '33000',
                'region_name'         => 'Yên Bái',
            ],
            
        ];

        foreach ($data as $item) {
            $regionMaster = new RegionMaster();
            $regionMaster->setConnection(DatabaseDefs::CONNECTION_NAME_MIGRATION);
            /** @var \Illuminate\Database\Eloquent\Builder $regionMaster */
            $regionMaster->fill($item)->save();
        }
    }
}
