<?php
namespace App\Common\View;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

/**
 * ViewModelクラスを表すインターフェースの実装を持つトレイト。
 *
 * @package App\Common\View
 */
trait ViewModelable
{
    /**
     * このViewModelで扱うデータの配列。
     * @var array
     */
    private array $attributes = [];

    /**
     * モデルクラスのAttributesの情報を設定する。
     *
     * @param  \Illuminate\Database\Eloquent\Model $model このViewModelで扱うモデルクラス
     * @return void
     */
    public function setAttributes(Model $model)
    {
        foreach (array_keys($model->getAttributes()) as $key) {
            $this->attributes[$key] = $model->getAttribute($key);
        }
    }

    /**
     * 配列から情報を設定する。
     *
     * @param  array $attributes このViewModelで扱うデータ
     * @return void
     */
    public function setAttributesFromArray(array $attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * Attributeにデータを追加する。
     *
     * @param string $key データに対応したキー
     * @param mixed $attribute 設定したいデータ
     */
    public function appendAttribute(string $key, mixed $attribute)
    {
        $this->attributes[$key] = $attribute;
    }

    /**
     * データを取得する。
     *
     * @param  string $key 取得したいデータのキー(プロパティ名)
     * @return mixed
     */
    public function __get(string $key): mixed
    {
        return Arr::get($this->attributes, $key, null);
    }

    /**
     * データの存在を確認する。
     *
     * @param  string $key 確認したいデータのキー(プロパティ名)
     * @return bool
     */
    public function __isset(string $key): bool
    {
        return Arr::has($this->attributes, $key);
    }
}
