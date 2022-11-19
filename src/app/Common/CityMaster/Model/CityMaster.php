<?php
namespace App\Common\CityMaster\Model;

use App\Common\Database\Definition\DatabaseDefs;
use Illuminate\Database\Eloquent\Model;

/**
 * City Master
 * @package \App\Common\CityMaster
 *
 */
class CityMaster extends Model
{
    /**
     * テーブル名の定義。
     * @var string
     */
    const TABLE_NAME = 'city_master';

    /**
     * モデルが使用するテーブル名の定義。
     * @var string
     */
    protected $table = self::TABLE_NAME;

    /**
     * このモデルが使用する基本の接続名の定義。
     * @var string
     */
    protected $connection = DatabaseDefs::CONNECTION_NAME_READ;

    /**
     * モデルのPrimaryKeyとなるカラムの名称。
     * @var string
     */
    protected $primaryKey = 'city_code';

    /**
     * create()等で値の代入が許可される項目の定義。
     * @var array<int, string>
     */
    protected $fillable = [
        'city_code',
        'city_name',
    ];
}
