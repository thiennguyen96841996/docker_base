<?php
namespace GLC\Client\Auth\Forms;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;

/**
 * ログイン処理用のFormRequestクラス。
 *
 * @package GLC\Client\Auth\Forms
 * @author  TinhNC <tinhhang22@gmail.com>
 */
class GLC extends FormRequest
{
    /**
     * 認証が必要なリクエストかどうかを返す。
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * バリデーション対象となるデータを取得する。
     *
     * @return array
     */
    public function validationData(): array
    {
        return $this->only([
            'id',
            'password',
        ]);
    }

    /**
     * バリデーションルールの配列を取得する。
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'id'       => 'required|integer',
            'password' => 'required|string'
        ];
    }

    /**
     * バリデーションメッセージの配列を取得する。
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'id.required'       => 'ログイン情報が誤っています。',
            'id.integer'        => 'ログイン情報が誤っています。',
            'id.size'           => 'ログイン情報が誤っています。',
            'password.required' => 'ログイン情報が誤っています。',
            'password.string'   => 'ログイン情報が誤っています。',
            'password.password' => 'ログイン情報が誤っています。',
        ];
    }

    /**
     * バリデーション要素の表示名の配列を取得する。
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'id'       => '「ID」',
            'password' => '「パスワード」',
        ];
    }

    public function all($keys = null): array
    {
        $all = parent::all();
        $all['id'] = str_replace('S', '', Arr::get($all, 'id'));
        return $all;
    }
}