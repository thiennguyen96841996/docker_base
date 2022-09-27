<?php
namespace App\Common\View\Contract;

use Illuminate\Database\Eloquent\Model;

/**
 * ViewModelクラスを表すインターフェース。
 *
 * @package App\Common\View\Contracts
 */
interface ViewModel
{
    /**
     * ModelのAttributesをこのクラスのAttributesに設定する。
     *
     * @param  \Illuminate\Database\Eloquent\Model $model このViewModelで扱うモデルクラス
     * @return void
     */
    public function setAttributes(Model $model);

    /**
     * 配列から情報を設定する。
     *
     * @param  array $attributes このViewModelで扱うデータ
     * @return void
     */
    public function setAttributesFromArray(array $attributes);

    /**
     * Attributeにデータを追加する。
     *
     * @param string $key データに対応したキー
     * @param mixed $attribute 設定したいデータ
     */
    public function appendAttribute(string $key, mixed $attribute);
}
