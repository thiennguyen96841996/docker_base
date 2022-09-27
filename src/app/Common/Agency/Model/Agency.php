<?php
namespace App\Common\Agency\Model;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Common\Database\Definition\DatabaseDefs;
use Illuminate\Support\Arr;

/**
 * 管理ユーザー情報のモデル。
 * @package \App\Common\Sample
 *
 * @method \Illuminate\Database\Eloquent\Builder whereMultiConditions(array $searchConditions)
 */
class Agency extends Model
{
    use SoftDeletes;

    /**
     * テーブル名の定義。
     * @var string
     */
    const TABLE_NAME = 'agencies';

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
    protected $primaryKey = 'id';

    /**
     * create()等で値の代入が許可される項目の定義。
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'tel',
        'address',
    ];


    /**
     * 取得時にキャストされるプロパティとそのキャスト先のマッピングの定義。
     * @var array<string, string>
     */
    protected $casts = [
        'created_at'        => 'datetime:Y/m/d H:i:s',
        'updated_at'        => 'datetime:Y/m/d H:i:s',
        'deleted_at'        => 'datetime:Y/m/d H:i:s',
    ];

    /**
     * パラメーター毎の表示名の定義を取得する。
     * ※ FormRequestで使用するものだけ定義すればOK。
     * @return array<string, array<int,string>>
     */
    public static function getAttributeNames(): array
    {
        return [
            'id'              => '「ID」',
            'name'            => '「Name」',
            'tel'             => '「Tel」',
            'address'         => '「Address」',
        ];
    }

    /**
     * 検索条件の配列からWhere句を設定する。
     * @param  \Illuminate\Database\Eloquent\Builder $builder
     * @param  array $searchConditions
     * @return \Illuminate\Database\Eloquent\Builder
     * @throws \Exception
     */
    public function scopeWhereMultiConditions(Builder $builder, array $searchConditions): Builder
    {
        // Id
        if (!empty($id = Arr::get($searchConditions, 'id'))) {
            $builder->where(self::TABLE_NAME . '.id', '=', $id);
        }
        // Name
        if (!empty($name = Arr::get($searchConditions, 'name'))) {
            $builder->where(self::TABLE_NAME . '.name',  'like', "%{$name}%");
        }
        // Tel
        if (!empty($tel = Arr::get($searchConditions, 'tel'))) {
            $builder->where(self::TABLE_NAME . '.tel', '=', $tel);
        }
        // Address
        if (!empty($address = Arr::get($searchConditions, 'address'))) {
            $builder->where(self::TABLE_NAME . '.address', 'like', "%{$address}%");
        }

        return $builder;
    }
}
