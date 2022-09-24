<?php
namespace Database\Seeders\Partial;

use Illuminate\Database\Seeder;
use App\Common\Database\Definition\AvailableStatus;
use App\Common\Database\Definition\DatabaseDefs;
use App\Common\AdminUser\Model\AdminUser;

/**
 * AdminUserモデルの初期データを登録するクラス。
 * @package \Database\Seeders
 */
class AdminUserSeeder extends Seeder
{
    /**
     * 初期データを登録する。
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name'         => '渡辺英助',
                'name_kana'    => 'ワタナベエイスケ',
                'email'        => 'eisuke@dev.speedy',
                'tel'          => '09000000001',
                'password'     => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'is_available' => AvailableStatus::AVAILABLE->value
            ],
        ];

        foreach ($data as $datum) {
            $adminUser = new AdminUser();
            $adminUser->setConnection(DatabaseDefs::CONNECTION_NAME_MIGRATION);

            /** @var \Illuminate\Database\Eloquent\Builder $adminUser */
            $adminUser->updateOrCreate(
                [ 'email' => $datum['email'] ],
                [
                    'name'         => $datum['name'],
                    'name_kana'    => $datum['name_kana'],
                    'email'        => $datum['email'],
                    'tel'          => $datum['tel'],
                    'password'     => $datum['password'],
                    'is_available' => $datum['is_available'],
                ]
            );
        }
    }
}
