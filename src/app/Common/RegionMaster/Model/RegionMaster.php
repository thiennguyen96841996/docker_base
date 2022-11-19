<?php
namespace App\Common\RegionMaster\Model;

use App\Common\Database\Definition\DatabaseDefs;
use Illuminate\Database\Eloquent\Model;

/**
 * region master
 * @package \App\Common\RegionMaster
 *
 */
class RegionMaster extends Model
{
    /**
     * テーブル名の定義。
     * @var string
     */
    const TABLE_NAME = 'region_master';

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
    protected $primaryKey = 'region_code';

    /**
     * create()等で値の代入が許可される項目の定義。
     * @var array<int, string>
     */
    protected $fillable = [
        'region_code',
        'region_name',
    ];
}
