<?php
namespace GLC\Platform\Firebase\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use GLC\Platform\Database\Models\AbsBaseModel;

/**
 * デバイストークンの情報を扱うモデルクラス。
 *
 * <pre>
 * +--------------+--------------+------+-----+---------+----------------+
 * | Field        | Type         | Null | Key | Default | Extra          |
 * +--------------+--------------+------+-----+---------+----------------+
 * | id           | int          | NO   | PRI | NULL    | auto_increment |
 * | customer_id  | int          | NO   |     | NULL    |                |
 * | device_token | varchar(255) | NO   |     | NULL    |                |
 * | created_at   | timestamp    | YES  |     | NULL    |                |
 * | updated_at   | timestamp    | YES  |     | NULL    |                |
 * +--------------+--------------+------+-----+---------+----------------+
 * </pre>
 *
 * @package GLC\Platform\Firebase\Models
 *
 * [ For IDE ]
 * @method $this|\Illuminate\Database\Eloquent\Builder whereMultiConditions(array $searchConditions)
 * @method \Illuminate\Pagination\LengthAwarePaginator asPaginator(string $path, int $page)
 *
 * @property int    id                       デバイストークンID
 * @property int    customer_id              カスタマID
 * @property string device_token             デバイストークン
 * @property \Carbon\Carbon created_at       作成日時
 * @property \Carbon\Carbon updated_at       更新日時
 */
class DeviceToken extends AbsBaseModel
{
    use HasFactory;

    /**
     * テーブル名の定義。
     * @var string
     */
    const TABLE_NAME = 'customer_device_tokens';

    /**
     * モデルが使用するテーブル名の定義。
     * @var string
     */
    protected $table = self::TABLE_NAME;

    /**
     * モデルのPrimaryKeyとなるカラムの名称。
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * PrimaryKeyの型の定義。
     * @var int
     */
    protected $keyType = 'integer';

    /**
     * PrimaryKeyがAutoIncrementかどうかの定義。
     * @var bool
     */
    public $incrementing = true;

    /**
     * Carbonに自動変換する日付型カラムの定義。
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

//〜・〜・〜・〜・〜・〜・〜・〜・〜・〜・〜・〜・〜・〜
//   Scopes
//〜・〜・〜・〜・〜・〜・〜・〜・〜・〜・〜・〜・〜・〜
    /**
     * 検索条件に合わせてWhere句を設定する。
     *
     * @param  \Illuminate\Database\Eloquent\Builder $builder Builderオブジェクト
     * @param  array $searchConditions 検索条件の配列
     * @return \Illuminate\Database\Eloquent\Builder Builderオブジェクト
     */
    public function scopeWhereMultiConditions(Builder $builder, array $searchConditions): Builder
    {
        foreach ($searchConditions as $key => $value) {
            switch ($key) {

                //customer_device_tokensテーブルでのwhere,whereNotIn,whereIn
                default:
                    $this->addWhereStatement($builder, $searchConditions, $key);
                    break;
            }
        }

        return $builder;
    }
}