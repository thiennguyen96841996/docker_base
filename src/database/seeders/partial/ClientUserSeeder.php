<?php
namespace Database\Seeders\Partial;

use Illuminate\Database\Seeder;
use App\Common\Database\Definition\AvailableStatus;
use App\Common\Database\Definition\DatabaseDefs;
use App\Common\ClientUser\Model\ClientUser;

/**
 * ClientUserモデルの初期データを登録するクラス。
 * @package \Database\Seeders
 */
class ClientUserSeeder extends Seeder
{
    /**
     * 初期データを登録する。
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'agency_id'    => '10001',
                'name'         => 'スピード太郎',
                'name_kana'    => 'スピードタロウ',
                'email'        => 'tarou@dev.speedy',
                'tel'          => '09000000001',
                'password'     => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'is_available' => AvailableStatus::AVAILABLE->value
            ],
        ];

        foreach ($data as $datum) {
            $clientUser = new ClientUser();
            $clientUser->setConnection(DatabaseDefs::CONNECTION_NAME_MIGRATION);

            /** @var \Illuminate\Database\Eloquent\Builder $clientUser */
            $clientUser->updateOrCreate(
                [ 'email' => $datum['email'] ],
                [
                    'agency_id'    => $datum['agency_id'],
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
