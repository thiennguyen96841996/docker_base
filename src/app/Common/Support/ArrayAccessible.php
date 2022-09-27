<?php
namespace App\Common\Support;

use Illuminate\Support\Facades\Log;

/**
 * ArrayAccessの実装を持つトレイト。
 * ※ offsetXXX()系の関数のエイリアスも持つ。
 *
 * @package App\Common\Support
 */
trait ArrayAccessible
{
    /**
     * 登録されたデータを保持する変数。
     * @var array
     */
    private array $container = [];

    /**
     * $offsetに紐づくデータが存在するかどうか。
     *
     * @param  mixed $offset 連想配列のキー
     * @return bool
     */
    public function offsetExists(mixed $offset): bool
    {
        return isset($this->container[$offset]);
    }

    /**
     * $offsetに紐づくデータが存在するかどうか。
     * ※ offsetExistsのエイリアス
     *
     * @param  mixed $key 連想配列のキー
     * @return bool
     */
    public function exists(mixed $key): bool
    {
        return $this->offsetExists($key);
    }

    /**
     * $offsetに紐づくデータを取得する。
     *
     * @param  mixed $offset 連想配列のキー
     * @return mixed
     */
    public function offsetGet(mixed $offset): mixed
    {
        if ($this->offsetExists($offset)) {
            return $this->container[$offset];
        }
        return null;
    }

    /**
     * $offsetに紐づくデータを取得する。
     * ※ offsetGetのエイリアス
     *
     * @param  mixed $key 連想配列のキー
     * @param  mixed $default データがない場合に返却される値
     * @return mixed
     */
    public function get(mixed $key, $default = null): mixed
    {
        if (empty($ret = $this->offsetGet($key))) {
            return $default;
        }
        return $ret;
    }

    /**
     * $offsetに紐づくデータを設定する。
     *
     * @param  mixed $offset 連想配列のキー
     * @param  mixed $value $offsetに紐付けるデータ
     * @return void
     */
    public function offsetSet(mixed $offset, mixed $value)
    {
        if (!is_null($offset)) {
            $this->container[$offset] = $value;
        } else {
            Log::channel('error')->error('Offset is null. Please check.');
        }
    }

    /**
     * $offsetに紐づくデータを設定する。
     * ※ offsetSetのエイリアス
     *
     * @param  mixed $key 連想配列のキー
     * @param  mixed $value $offsetに紐付けるデータ
     * @return void
     */
    public function set(mixed $key, mixed $value)
    {
        $this->offsetSet($key, $value);
    }

    /**
     * $offsetに紐づくデータを削除する。
     *
     * @param  mixed $offset 連想配列のキー
     * @return void
     */
    public function offsetUnset(mixed $offset)
    {
        if ($this->offsetExists($offset)) {
            unset($this->container[$offset]);
        }
    }

    /**
     * $offsetに紐づくデータを削除する。
     * ※ offsetUnsetのエイリアス
     *
     * @param  mixed $key 連想配列のキー
     * @return void
     */
    public function remove(mixed $key)
    {
        $this->offsetUnset($key);
    }
}
