<?php

namespace Database\Seeders\Partial;

use Illuminate\Database\Seeder;
use App\Common\Database\Definition\DatabaseDefs;
use App\Common\Database\MysqlCryptorTrait;
use App\Common\Project\Definition\ProjectStatus;
use App\Common\Project\Model\Project;

/**
 * ClientProjectモデルの初期データを登録するクラス。
 * @package \Database\Seeders
 */
class ClientProjectSeeder extends Seeder
{
    use MysqlCryptorTrait;
    /**
     * 初期データを登録する。
     * @return void
     */
    public function run()
    {
        $title = [
            'HOT - 1.4 TỶ FULL NỘI THẤT XỊN - NHÀ ĐẸP NHƯ MỚI - 2PN 2VC',
            'Bất động sản tài phiệt'
        ];

        for ($i = 1; $i <= 1000; $i++) {
            $clientProject = new Project();
            $clientProject->setConnection(DatabaseDefs::CONNECTION_NAME_MIGRATION);

            /** @var \Illuminate\Database\Eloquent\Builder $clientProject */
            $clientProject->fill([
                'client_id'    => rand(10001, 11000),
                'title'        => $i % 2 ? $title[0] : $title[1],
                'status'       => $i % 4 ? ProjectStatus::PRIVATE->value : ProjectStatus::PUBLIC->value,
                'description'      => "Đây là căn hộ gia đình ở cực kỳ đẹp",
                'city_code'         => 1,
                'district_code'     => $i % 2 ? 1 : 2,
                'address'           => '0011 PHAN KẾ BÍNH, PHƯỜNG CỐNG VỊ',
                'price'             => rand(100000000, 50000000000),
                'area'              => rand(50, 500),
                'avatar'            => 'not-image',
                'region_code'       => 90000,
                'project_category_code'       => rand(100, 104)
            ])->save();
        }
    }
}
