<?php
namespace GLC\Platform\Database\Contracts;

use GLC\Platform\Repository\Contracts\ModelRepository;

/**
 * AssignIdモデルに関連した処理を行うリポジトリを表すインターフェイス。
 *
 * @package GLC\Platform\Database\Contracts
 * @author  TinhNC <tinhhang22@gmail.com>
 */
interface AssignIdRepository extends ModelRepository
{
    /**
     * 新しいIDを割り当てる。
     *
     * @param  string $prefix 取得したいIDのプリフィックス
     * @return string
     */
    public function assignNewId(string $prefix): string;
}