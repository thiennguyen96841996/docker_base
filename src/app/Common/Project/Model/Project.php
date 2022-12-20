<?php

namespace App\Common\Project\Model;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Common\Database\Definition\DatabaseDefs;
use Cviebrock\EloquentSluggable\Sluggable;

/**
 * プロジェクト情報のモデル。
 * @package \App\Common\Project
 *
 * @method \Illuminate\Database\Eloquent\Builder whereMultiConditions(array $searchConditions)
 */
class Project extends Model
{
    use SoftDeletes, Sluggable;

    /**
     * テーブル名の定義。
     * @var string
     */
    const TABLE_NAME = 'client_projects';

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
        'client_id',
        'title',
        'status',
        'avatar',
        'description',
        'city_code',
        'district_code',
        'address',
        'price',
        'area',
        'region_code',
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
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    /**
     * パラメーター毎の表示名の定義を取得する。
     * ※ FormRequestで使用するものだけ定義すればOK。
     * @return array<string, array<int,string>>
     */
    public static function getAttributeNames(): array
    {
        return [
            'title'              => '「Title」',
            'status'             => '「Status」',
            'avatar'             => '「Avatar」',
            'description'        => '「Description」',
            'city'               => '「City」',
            'district'           => '「District」',
            'address'            => '「Address」',
            'price'              => '「Price」',
            'area'               => '「Area」',
            'region_code'        => '「RegionCode」',
            'client_id'          => '「ClientId」',
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
                // title
                'title' => !empty($value) ? $builder->whereRaw("lower(title) LIKE '%" . mb_strtolower($value) . "%'") : null,
                // description
                'description' => !empty($value) ? $builder->whereRaw("lower(description) LIKE '%" . mb_strtolower($value) . "%'") : null,
                // status
                'status' => !empty($value) ? $builder->where($this->qualifyColumn('status'), '=', $value) : null,
                // address
                'address' => !empty($value) ? $builder->whereRaw("lower(address) LIKE '%" . mb_strtolower($value) . "%'") : null,
                // client_id
                'client_id' => !empty($value) ? $builder->where($this->qualifyColumn('client_id'), '=', $value) : null,
                default => null,
            };
        }

        return $builder;
    }
}
