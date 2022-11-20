<?php

namespace Database\Seeders\Partial;

use App\Common\CityMaster\Model\CityMaster;
use App\Common\Database\Definition\DatabaseDefs;
use App\Common\DistrictMaster\Model\DistrictMaster;
use Illuminate\Database\Seeder;

/**
 * City and District master data seeder
 * @package \Database\Seeders
 */
class CityAndDistrictSeeder extends Seeder
{
    /**
     * 初期データを登録する。
     * @return void
     */
    public function run()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, 'https://provinces.open-api.vn/api/?depth=2');
        $result = curl_exec($ch);
        curl_close($ch);

        // start import city into cityDB
        $cities = json_decode($result);
        foreach ($cities as $city) {
            $cityMaster = new CityMaster();
            $cityMaster->setConnection(DatabaseDefs::CONNECTION_NAME_MIGRATION);
            /** @var \Illuminate\Database\Eloquent\Builder $cityMaster */
            $cityMaster->fill([
                'city_code' => $city->code,
                'city_name' => $city->name
            ])->save();

            // import district into districtDB
            foreach($city->districts as $district) {
                $dictrictMaster = new DistrictMaster();
                $dictrictMaster->setConnection(DatabaseDefs::CONNECTION_NAME_MIGRATION);
                /** @var \Illuminate\Database\Eloquent\Builder $dictrictMaster */
                $dictrictMaster->fill([
                    'district_code' => $district->code,
                    'district_name' => $district->name,
                    'city_code'     => $city->code
                ])->save();
            }
        }
    }
}
