<?php

namespace Database\Seeders\Partial;

use Illuminate\Database\Seeder;
use App\Common\Database\Definition\AvailableStatus;
use App\Common\Database\Definition\DatabaseDefs;
use App\Common\Customer\Model\Customer;
use App\Common\Database\MysqlCryptorTrait;

/**
 * CustomerUserモデルの初期データを登録するクラス。
 * @package \Database\Seeders
 */
class CustomerUserSeeder extends Seeder
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
                'name'         => $this->encrypt('スピード太郎'),
                'birthday'         => $this->encrypt('1999/09/11'),
                'email'        => 'tarou@dev.speedy',
                'tel'          => $this->encrypt('09000000001'),
                'address'          => $this->encrypt('東京都新宿'),
                'password'     => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            ],
        ];

        foreach ($data as $datum) {
            $customerUser = new Customer();
            $customerUser->setConnection(DatabaseDefs::CONNECTION_NAME_MIGRATION);

            /** @var \Illuminate\Database\Eloquent\Builder $customerUser */
            $customerUser->updateOrCreate(
                ['email' => $datum['email']],
                [
                    'name'         => $datum['name'],
                    'birthday'     => $datum['birthday'],
                    'email'        => $datum['email'],
                    'tel'          => $datum['tel'],
                    'address'      => $datum['address'],
                    'password'     => $datum['password'],
                ]
            );
        }
    }
}
