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
            \Database\Seeders\Partial\AdminUserSeeder::class,
            \Database\Seeders\Partial\ClientUserSeeder::class,
            \Database\Seeders\Partial\SampleSeeder::class,
        ]);
    }
}
