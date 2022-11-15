<?php

namespace Database\Seeders\Partial;

use App\Common\Database\MysqlCryptorTrait;
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
    use MysqlCryptorTrait;
    /**
     * 初期データを登録する。
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name'         => $this->encrypt('glc@admin'),
                'email'        => 'admin@glc.com',
                'password'     => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'last_login_at'     => '2022-11-16'
            ],
        ];

        foreach ($data as $datum) {
            $adminUser = new AdminUser();
            $adminUser->setConnection(DatabaseDefs::CONNECTION_NAME_MIGRATION);

            /** @var \Illuminate\Database\Eloquent\Builder $adminUser */
            $adminUser->updateOrCreate(
                [
                    'email'         => $datum['email'],
                    'name'          => $datum['name'],
                    'email'         => $datum['email'],
                    'password'      => $datum['password'],
                    'last_login_at' => $datum['last_login_at'],
                ]
            );
        }
    }
}
