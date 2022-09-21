<?php
namespace GLC\Platform\Auth\Forms;

use Illuminate\Foundation\Http\FormRequest;

/**
 * ログイン処理用のFormRequestクラス。
 *
 * @package GLC\Platform\Auth\Forms
 * @author  TinhNC <tinhhang22@gmail.com>
 */
class LoginRequest extends FormRequest
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
            'user_id',
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
            'user_id'  => 'required|string|size:10',
            'password' => 'required|string'. (is_production() ? '|password': '')
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
            'user_id.required'       => ':attributeを入力してください。',
            'user_id.string'         => ':attributeの形式が正しくありません。',
            'user_id.size'           => ':attributeの形式が正しくありません。',
            'password.required' => ':attributeを入力してください。',
            'password.string'   => ':attributeの形式が正しくありません。',
            'password.password' => ':attributeの形式が正しくありません。',
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
            'user_id'  => '「ID」',
            'password' => '「パスワード」',
        ];
    }
}