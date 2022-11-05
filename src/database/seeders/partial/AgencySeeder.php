<?php
namespace Database\Seeders\Partial;

use App\Common\Agency\Model\Agency;
use Illuminate\Database\Seeder;
use App\Common\Database\Definition\DatabaseDefs;
use App\Common\Database\MysqlCryptorTrait;

/**
 * Agencyモデルの初期データを登録するクラス。
 * @package \Database\Seeders
 */
class AgencySeeder extends Seeder
{
    use MysqlCryptorTrait;
    /**
     * 初期データを登録する。
     * @return void
     */
    public function run()
    {
        $data = [
            'name'         => 'Agency Name',
            'tel'          => '09000000001',
            'address'      => '東京都板橋区高島平2-26-1-811',
        ];

        for($i = 1; $i <= 1000; $i++) {
            $agency = new Agency();
            $agency->setConnection(DatabaseDefs::CONNECTION_NAME_MIGRATION);

            /** @var \Illuminate\Database\Eloquent\Builder $agency */
            $agency->fill($data);
            $agency->save();
        }
    }
}
