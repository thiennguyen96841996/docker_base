<?php
namespace App\Common\AgencyContract\Model;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Common\Database\Definition\DatabaseDefs;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * AgencyContract情報のモデル。
 * @package App\Common\AgencyContract\Model
 *
 * @method \Illuminate\Database\Eloquent\Builder whereMultiConditions(array $searchConditions)
 */
class AgencyContract extends Model
{
    use SoftDeletes;
    /**
     * テーブル名の定義。
     * @var string
     */
    const TABLE_NAME = 'agency_contracts';

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
        'agency_id',
        'expire_in',
        'start_date',
        'end_date',
    ];


    /**
     * 取得時にキャストされるプロパティとそのキャスト先のマッピングの定義。
     * @var array<string, string>
     */
    protected $casts = [
        'created_at'            => 'datetime:Y/m/d H:i:s',
        'updated_at'            => 'datetime:Y/m/d H:i:s',
        'deleted_at'            => 'datetime:Y/m/d H:i:s',
        'start_date'            => 'datetime:Y/m/d H:i:s',
        'end_date'              => 'datetime:Y/m/d H:i:s',
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
            'start_date'                => '「Ngày kí kết hợp đồng」',
            'end_date'                  => '「Ngày kết thúc hợp đồng」',
            'expire_in'                 => '「Thời hạn hợp đồng」',
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
                // agency_id
                'agency_id' => !empty($value) ? $builder->where($this->qualifyColumn('agency_id'), '=', $value) : null,
                // expire_in
                'expire_in' => !empty($value) ? $builder->where($this->qualifyColumn('expire_in'), '=', $value) : null,
                // start_date
                'start_date' => !empty($value) ? $builder->where($this->qualifyColumn('start_date'), '=', Carbon::parse($value)->format('Y/m/d')) : null,
                // start_date_from
                'start_date_from' => !empty($value) ? $builder->where($this->qualifyColumn('start_date'), '>=', Carbon::parse($value)->format('Y/m/d')) : null,
                // start_date_to
                'start_date_to' => !empty($value) ? $builder->where($this->qualifyColumn('start_date'), '<', Carbon::parse($value)->format('Y/m/d')) : null,
                // end_date
                'end_date' => !empty($value) ? $builder->where($this->qualifyColumn('end_date'), '=', Carbon::parse($value)->format('Y/m/d')) : null,
                // end_date_from
                'end_date_from' => !empty($value) ? $builder->where($this->qualifyColumn('end_date'), '>=', Carbon::parse($value)->format('Y/m/d')) : null,
                // end_date_to
                'end_date_to' => !empty($value) ? $builder->where($this->qualifyColumn('end_date'), '<=', Carbon::parse($value)->format('Y/m/d')) : null,
                default => null,
            };
        }

        return $builder;
    }
}
