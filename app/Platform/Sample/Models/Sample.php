<?php

namespace GLC\Platform\Sample\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use GLC\Platform\Database\Models\AbsBaseModel;
use Illuminate\Support\Arr;

/**
 * サンプルの情報を扱うモデルクラス。
 *
 * <pre>
 * +-------------------------------+--------------+------+-----+---------+-------+
 * | Field                         | Type         | Null | Key | Default | Extra |
 * +-------------------------------+--------------+------+-----+---------+-------+
 * | id                            | integer      | NO   | PRI | NULL    |       |
 * | name                          | varchar(80)  | NO   |     | NULL    |       |
 * | email                         | varchar(255) | NO   |     | NULL    |       |
 * | text                          | varchar(255) | NO   |     | NULL    |       |
 * | created_at                    | timestamp    | YES  |     | NULL    |       |
 * | updated_at                    | timestamp    | YES  |     | NULL    |       |
 * | deleted_at                    | timestamp    | YES  |     | NULL    |       |
 * +-------------------------------+--------------+------+-----+---------+-------+
 * </pre>
 *
 * @package Wanriku\Platform\Sample\Models
 *
 * [ For IDE ]
 * @method $this|\Illuminate\Database\Eloquent\Builder whereMultiConditions(array $searchConditions)
 * @method \Illuminate\Pagination\LengthAwarePaginator asPaginator(string $path, int $page)
 *
 * @property string id                            ID
 * @property string name                          名前
 * @property string email                         Eメール
 * @property string text                          テキスト
 * @property \Carbon\Carbon created_at            作成日時
 * @property \Carbon\Carbon updated_at            更新日時
 * @property \Carbon\Carbon deleted_at            削除日時
 */
class Sample extends AbsBaseModel
{
    //TODO:?
    use HasFactory;

    protected $perPage = 10;

    const TABLE_NAME = 'samples';

    protected $table = self::TABLE_NAME;

    protected $primaryKey = 'id';

    public $incrementing = true;


    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function scopeWhereMultiConditions(Builder $builder, array $searchConditions): Builder
    {
        if (! empty($sampleId = Arr::get($searchConditions, 'id'))) {
            $builder->where(self::TABLE_NAME. '.id', '=', $sampleId);
        }
        return $builder;
    }
}