<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * シーダーをまとめて実行するクラス。
 * @package \Database\Seeders
 */
class DatabaseSeeder extends Seeder
{
    /**
     * シーディングする。
     * @return void
     */
    public function run()
    {
        $this->call([
            \Database\Seeders\Partial\AgencySeeder::class,
            \Database\Seeders\Partial\AdminUserSeeder::class,
            \Database\Seeders\Partial\ClientUserSeeder::class,
            \Database\Seeders\Partial\ClientPostSeeder::class,
            \Database\Seeders\Partial\ClientNewsSeeder::class,
            \Database\Seeders\Partial\CustomerUserSeeder::class,
            \Database\Seeders\Partial\CityAndDistrictSeeder::class,
            \Database\Seeders\Partial\RegionMasterSeeder::class,
            \Database\Seeders\Partial\ClientProjectSeeder::class,
            \Database\Seeders\Partial\ProjectCategoryMasterSeeder::class,
            \Database\Seeders\Partial\SampleSeeder::class,
        ]);
    }
}
