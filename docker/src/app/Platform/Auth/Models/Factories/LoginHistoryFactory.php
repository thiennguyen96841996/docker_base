<?php
namespace GLC\Platform\Auth\Models\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use GLC\Platform\Auth\Models\LoginHistory;

/**
 * Employeeモデルのファクトリークラス。
 *
 * @package GLC\Platform\Employee\Models\Factories
 * @author  Odo Ari <flasanpal@yahoo.co.jp>
 */
class LoginHistoryFactory extends Factory
{
    /**
     * このクラスに対応するモデルクラスの名前。
     * @var string
     */
    protected $model = LoginHistory::class;

    /**
     * モデルのデフォルトの状態を取得する。
     *
     * @return array
     * @throws \Throwable
     */
    public function definition()
    {
        return [
            // TODO 実装する
        ];
    }
}