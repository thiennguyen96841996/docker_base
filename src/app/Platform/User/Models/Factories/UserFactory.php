<?php
namespace GLC\Platform\User\Models\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use GLC\Platform\User\Models\User;

/**
 * Userモデルのファクトリークラス。
 *
 * @package GLC\Platform\User\Models\Factories
 * @author  Odo Ari <flasanpal@yahoo.co.jp>
 */
class UserFactory extends Factory
{
    /**
     * このクラスに対応するモデルクラスの名前。
     * @var string
     */
    protected $model = User::class;

    /**
     * モデルのデフォルトの状態を取得する。
     *
     * @return array
     * @throws \Throwable
     */
    public function definition()
    {
        return [
            'id'             => 'UF'. str_pad(rand(1, 100), 8, '0', STR_PAD_LEFT), // Factory用のIDにする
            'name'           => $this->faker->name,
            'email'          => $this->faker->unique()->safeEmail,
            'password'       => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'last_login_at'  => now()->subHours(1)->format('Y-m-d H:i:s'),
            'created_at'     => now()->subDays(7)->format('Y-m-d H:i:s'),
            'updated_at'     => now()->subDays(3)->format('Y-m-d H:i:s'),
        ];
    }

    /**
     * ユーザーが削除されている状態にする。
     *
     * @return UserFactory
     */
    public function deleted(): UserFactory
    {
        return $this->state(function () {
            return [
                'deleted_at' => now()->format('Y-m-d H:i:s'),
            ];
        });
    }
}