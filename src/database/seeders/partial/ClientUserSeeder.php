<?php

namespace Database\Seeders\Partial;

use Illuminate\Database\Seeder;
use App\Common\Database\Definition\DatabaseDefs;
use App\Common\ClientUser\Model\ClientUser;
use App\Common\Database\Definition\StatusUser;
use App\Common\Database\MysqlCryptorTrait;

/**
 * ClientUserモデルの初期データを登録するクラス。
 * @package \Database\Seeders
 */
class ClientUserSeeder extends Seeder
{
    use MysqlCryptorTrait;
    /**
     * 初期データを登録する。
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 10000; $i++) {
            $clientUser = new ClientUser();
            $clientUser->setConnection(DatabaseDefs::CONNECTION_NAME_MIGRATION);

            /** @var \Illuminate\Database\Eloquent\Builder $clientUser */
            $clientUser->fill([
                'agency_id'    => rand(10001, 11000),
                'name'         => $this->encrypt($i % 3 ? 'Nguyễn Văn Lợi' : 'Nguyễn Đặng Thuỳ Huyền Trang'),
                'email'        => 'tarou' . $i . '@dev.speedy',
                'tel'          => $this->encrypt('090999' . rand(1000, 9999)),
                'password'     => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'status'       => $i % 4 ? StatusUser::ACTIVE->value : StatusUser::INACTIVE->value,
                'region_code'  => $i % 2 ? 10000 : 60000,
                'hotline'      => $this->encrypt('090999' . rand(1000, 9999)),
            ])->save();
        }
    }
}
