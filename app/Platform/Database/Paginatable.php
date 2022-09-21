<?php
namespace GLC\Platform\Database;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use GLC\Platform\Http\Definitions\ParameterDefs;

/**
 * モデルにページネーションのためのスコープを提供するトレイト。
 *
 * @package GLC\Platform\Database
 * @author  TinhNC <tinhhang22@gmail.com>
 */
trait Paginatable
{
    /**
     * モデルのデータをPaginatorとして取得する。
     *
     * @param  \Illuminate\Database\Eloquent\Builder $builder Builderオブジェクト
     * @param  string $path URLのパス
     * @param  int $page ページ番号
     * @return \Illuminate\Pagination\LengthAwarePaginator LengthAwarePaginatorオブジェクト
     */
    public function scopeAsPaginator(Builder $builder, string $path, int $page): LengthAwarePaginator
    {
        /** @var \Illuminate\Pagination\LengthAwarePaginator $paginator */
        $paginator = $builder->paginate(
            $this->perPage,
            [ '*' ],
            ParameterDefs::PARAM_NAME_PAGE,
            $page
        );
        $paginator->setPath($path);

        return $paginator;
    }
}