<?php
namespace App\Common\Sample\Model;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Common\Database\Definition\DatabaseDefs;

/**
 * 管理ユーザー情報のモデル。
 * @package \App\Common\Sample
 *
 * @method \Illuminate\Database\Eloquent\Builder whereMultiConditions(array $searchConditions)
 */
class Sample extends Authenticatable
{
    use SoftDeletes, Notifiable;

    /**
     * テーブル名の定義。
     * @var string
     */
    const TABLE_NAME = 'speedy_samples';

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
        'column1',
        'column2',
        'column3',
        'column4',
        'column5',
        'column6',
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
            'column1'         => 'column1',
            'column2'         => 'column2',
            'column3'         => 'column3',
            'column4'         => 'column4',
            'column5'         => 'column5',
            'column6'         => 'column6',
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
        foreach ($searchConditions as $key => $value) {
            match ($key) {
                // id
                'id' => $builder->where($this->qualifyColumn('id'), $value),
                // column1
                'column1' => $builder->where($this->qualifyColumn('column1'), $value),
                // column2
                'column2' => $builder->where($this->qualifyColumn('column2'), $value),
                // column3
                'column3' => $builder->where($this->qualifyColumn('email'), $value),
                // column4
                'column4' => $builder->where($this->qualifyColumn('column4'), $value),
                // column5
                'column5' => $builder->where($this->qualifyColumn('column5'), $value),
                default => null,
            };
        }
        return $builder;
    }
}
