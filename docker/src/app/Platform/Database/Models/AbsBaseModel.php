<?php
namespace GLC\Platform\Database\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Expression;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use GLC\Platform\Database\Paginatable;

/**
 * 各モデルクラスの基底クラスとなるモデルクラス。
 *
 * @package GLC\Platform\Database\Models
 * @author  TinhNC <tinhhang22@gmail.com>
 */
abstract class AbsBaseModel extends Model
{
    use Paginatable;
    protected $perPage = 50;

    /**
     * 検索条件に合わせてWhere句を設定する。
     *
     * @param  \Illuminate\Database\Eloquent\Builder $builder Builderオブジェクト
     * @param  array $searchConditions 検索条件の配列
     * @return \Illuminate\Database\Eloquent\Builder Builderオブジェクト
     */
    abstract public function scopeWhereMultiConditions(Builder $builder, array $searchConditions): Builder;

    /**
     * Where句を追加する。
     *
     * @param  \Illuminate\Database\Eloquent\Builder $builder Builderオブジェクト
     * @param  array $searchConditions 検索条件の配列
     * @param  string $key 検索条件のキー
     * @param  string $operator オペレーターの文字列
     * @param  string|null $columnName 検索対象のカラム名
     */
    protected function addWhereStatement(Builder $builder, array $searchConditions, string $key, string $operator = '=', string $columnName = null)
    {
        if (!empty($data = Arr::get($searchConditions, $key))) {
            if (is_array($data)) {
                if ($operator === '<>') {
                    $builder->whereNotIn($this->qualifyColumn($columnName ?? $key), $data);
                } else {
                    $builder->whereIn($this->qualifyColumn($columnName ?? $key), $data);
                }
            } else {
                $builder->where($this->qualifyColumn($columnName ?? $key), $operator, $data);
            }
        }
    }

    /**
     * 復号化して検索するためのQueryExpressionを取得する。
     *
     * @param  string $tableName テーブル名
     * @param  string $columnName カラム名
     * @return \Illuminate\Database\Query\Expression QueryExpressionオブジェクト
     */
    protected function getWhereQueryExpressionAsDecrypt(string $tableName, string $columnName): Expression
    {
        return DB::raw(
            sprintf("convert(AES_DECRYPT(UNHEX({$tableName}.{$columnName}), '%s') USING utf8mb4)",
                env('ENCRYPT_KEY')
            )
        );
    }
}