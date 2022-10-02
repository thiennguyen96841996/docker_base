<?php
namespace Database\Seeders\Partial;

use App\Common\Database\MysqlCryptorTrait;
use App\Common\Sample\Model\Sample;
use Illuminate\Database\Seeder;
use App\Common\Database\Definition\DatabaseDefs;

/**
 * AdminUserモデルの初期データを登録するクラス。
 * @package \Database\Seeders
 */
class SampleSeeder extends Seeder
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
                'column1'           => 'TEST',
                'column2'           => 'TEST',
                'column3'           => 'TEST',
                'column4'           => 'TEST',
                'column5'           => 'TEST',
                'column6'           => 'TEST',
            ],
        ];

        foreach ($data as $datum) {
            $sample = new Sample();
            $sample->setConnection(DatabaseDefs::CONNECTION_NAME_MIGRATION);
            $sample->fill($datum);

            $sample->save();
        }
    }
}
