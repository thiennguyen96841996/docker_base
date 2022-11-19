<?php

namespace Database\Seeders\Partial;

use Illuminate\Database\Seeder;
use App\Common\Database\Definition\AvailableStatus;
use App\Common\Database\Definition\DatabaseDefs;
use App\Common\Customer\Model\Customer;
use App\Common\Database\Definition\Gender;
use App\Common\Database\Definition\Status;
use App\Common\Database\Definition\StatusUser;
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
        for ($i = 1; $i <= 10000; $i++) {
            $customerUser = new Customer();
            $customerUser->setConnection(DatabaseDefs::CONNECTION_NAME_MIGRATION);

            /** @var \Illuminate\Database\Eloquent\Builder $customerUser */
            $customerUser->fill([
                'name'         => $this->encrypt($i % 3 ? 'Nguyễn Văn Lợi' : 'Nguyễn Thuỳ Huyền Trang'),
                'tel'          => $this->encrypt('090999' . rand(1000, 9999)),
                'birthday'     => $this->encrypt('19' . rand(40, 99) . '/' . rand(0, 12) . '/' . rand(1, 30)),
                'address'      => $this->encrypt('0011' . $i . ' PHAN KẾ BÍNH, PHƯỜNG CỐNG VỊ, QUẬN BA ĐÌNH, HÀ NỘI'),
                'email'        => 'tarou0' .  $i . '@dev.speedy',
                'password'     => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'gender'       => $this->encrypt($i % 3 ? Gender::MALE->value : Gender::FEMALE->value),
            ])->save();
        }
    }
}
