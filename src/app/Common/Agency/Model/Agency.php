<?php
namespace App\Common\Agency\Model;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Common\Database\Definition\DatabaseDefs;
use Carbon\Carbon;

/**
 * Agency情報のモデル。
 * @package \App\Common\Sample
 *
 * @method \Illuminate\Database\Eloquent\Builder whereMultiConditions(array $searchConditions)
 */
class Agency extends Model
{

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
        'status',
        'agency_director',
        'establishment_date',
    ];


    /**
     * 取得時にキャストされるプロパティとそのキャスト先のマッピングの定義。
     * @var array<string, string>
     */
    protected $casts = [
        'created_at'            => 'datetime:Y/m/d H:i:s',
        'updated_at'            => 'datetime:Y/m/d H:i:s',
        'deleted_at'            => 'datetime:Y/m/d H:i:s',
        'establishment_date'    => 'datetime:Y/m/d H:i:s',
    ];

    /**
     * パラメーター毎の表示名の定義を取得する。
     * ※ FormRequestで使用するものだけ定義すればOK。
     * @return array<string, array<int,string>>
     */
    public static function getAttributeNames(): array
    {
        return [
            'id'                        => '「ID」',
            'name'                      => '「Tên」',
            'tel'                       => '「Sđt」',
            'address'                   => '「Địa chỉ」',
            'status'                    => '「Status」',
            'agency_director'           => '「Giám đốc đại lý」',
            'establishment_date'        => '「Ngày thành lập」',
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
                'id' => !empty($value) ? $builder->where($this->qualifyColumn('id'), '=', $value) : null,
                // name
                'name' => !empty($value) ? $builder->whereRaw("lower(name) LIKE '%". mb_strtolower($value) . "%'") :null,
                // tel
                'tel' => !empty($value) ? $builder->where($this->qualifyColumn('tel'), '=', $value) : null,
                // address
                'address' => !empty($value) ? $builder->whereRaw("lower(address) LIKE '%". mb_strtolower($value) . "%'") : null,
                // status
                'status' => !empty($value) ? $builder->where($this->qualifyColumn('status'), '=', $value) : null,
                // agency_director
                'agency_director' => !empty($value) ? $builder->whereRaw("lower(agency_director) LIKE '%". mb_strtolower($value) . "%'") : null,
                // establishment_date
                'establishment_date' => !empty($value) ? $builder->where($this->qualifyColumn('establishment_date'), '=', Carbon::parse($value)->format('Y/m/d')) : null,
                default => null,
            };
        }

        return $builder;
    }
}
