<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Common\Database\Definition\AvailableStatus;

/**
 * Userモデルに対応したファクトリー。
 * @package \Database\Factories
 */
class ClientUserFactory extends Factory
{
    /**
     * モデルの基本状態を定義する。
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'         => 'クライアント太郎',
            'name_kana'    => 'クライアントタロウ',
            'email'        => $this->faker->unique()->safeEmail(),
            'tel'          => '09000000000',
            'password'     => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'is_available' => AvailableStatus::AVAILABLE->value,
        ];
    }

    /**
     * 削除済み状態を定義する。
     * @return ClientUserFactory
     */
    public function deleted(): ClientUserFactory
    {
        return $this->state(function () {
            return [
                'deleted_at' => now(),
            ];
        });
    }
}
