<?php

namespace Database\Seeders\Partial;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Common\Database\Definition\DatabaseDefs;
use App\Common\ProjectCategoryMaster\Model\ProjectCategoryMaster;
use App\Common\RegionMaster\Model\RegionMaster;

/**
 * ProjectCategoryMasterSeederモデルの初期データを登録するクラス。
 * @package \Database\Seeders
 */
class ProjectCategoryMasterSeeder extends Seeder
{
    /**
     * 初期データを登録する。
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'project_category_code'         => '100',
                'project_category_name'         => 'Căn hộ chung cư',
            ],
            [
                'project_category_code'         => '101',
                'project_category_name'         => 'Văn phòng',
            ],
            [
                'project_category_code'         => '102',
                'project_category_name'         => 'Trung tâm thương mại',
            ],
            [
                'project_category_code'         => '103',
                'project_category_name'         => 'Khu đô thị',
            ],
            [
                'project_category_code'         => '104',
                'project_category_name'         => 'Biệt thự nhà vườn',
            ],

        ];

        foreach ($data as $item) {
            $projectCategoryMaster = new ProjectCategoryMaster();
            $projectCategoryMaster->setConnection(DatabaseDefs::CONNECTION_NAME_MIGRATION);
            /** @var \Illuminate\Database\Eloquent\Builder $projectCategoryMaster */
            $projectCategoryMaster->fill($item)->save();
        }
    }
}
