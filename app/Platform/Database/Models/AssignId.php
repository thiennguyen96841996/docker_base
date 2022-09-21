<?php
namespace GLC\Platform\Database\Models;

use Illuminate\Database\Eloquent\Builder;

/**
 * IDの情報を扱うモデルクラス。
 *
 * <pre>
 * +----------------+--------------+------+-----+---------+-------+
 * | Field          | Type         | Null | Key | Default | Extra |
 * +----------------+--------------+------+-----+---------+-------+
 * | prefix         | char(3)      | NO   | PRI | NULL    |       |
 * | count          | int(11)      | NO   |     | NULL    |       |
 * | created_at     | timestamp    | YES  |     | NULL    |       |
 * | updated_at     | timestamp    | YES  |     | NULL    |       |
 * +----------------+--------------+------+-----+---------+-------+
 * </pre>
 *
 * @package GLC\Platform\Database\Models
 * @author  TinhNC <tinhhang22@gmail.com>
 *
 * [ For IDE ]
 * @method $this|\Illuminate\Database\Eloquent\Builder whereMultiConditions(array $searchConditions)
 *
 * @property string prefix                プリフィックス
 * @property string count                 数値
 * @property \Carbon\Carbon created_at    作成日時
 * @property \Carbon\Carbon updated_at    更新日時
 */
class AssignId extends AbsBaseModel
{
    /**
     * テーブル名の定義。
     * @var string
     */
    const TABLE_NAME = 'assign_ids';

    /**
     * モデルが使用するテーブル名の定義。
     * @var string
     */
    protected $table = self::TABLE_NAME;

    /**
     * モデルのPrimaryKeyとなるカラムの名称。
     * @var string
     */
    protected $primaryKey = 'prefix';

    /**
     * PrimaryKeyの型の定義。
     * @var string
     */
    protected $keyType = 'string';

    /**
     * PrimaryKeyがAutoIncrementかどうかの定義。
     * @var bool
     */
    public $incrementing = false;

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
        $this->addWhereStatement($builder, $searchConditions, 'prefix');
        return $builder;
    }
}