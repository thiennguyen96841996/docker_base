<?php

namespace App\Common\ProjectCategoryMaster\Model;

use App\Common\Database\Definition\DatabaseDefs;
use Illuminate\Database\Eloquent\Model;

/**
 * Project Category Master
 * @package \App\Common\ProjectCategoryMaster
 *
 */
class ProjectCategoryMaster extends Model
{
    /**
     * テーブル名の定義。
     * @var string
     */
    const TABLE_NAME = 'project_category_master';

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
    protected $primaryKey = 'project_category_code';

    /**
     * create()等で値の代入が許可される項目の定義。
     * @var array<int, string>
     */
    protected $fillable = [
        'project_category_code',
        'project_category_name',
    ];
}
