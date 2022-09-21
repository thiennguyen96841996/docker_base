<?php
namespace GLC\Master\Auth\Forms;

use Illuminate\Foundation\Http\FormRequest;

/**
 * ログイン処理用のFormRequestクラス。
 *
 * @package GLC\Master\Auth\Forms
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
            'id'  => 'required|integer',
            'password' => 'required|string'. (is_production() ? '|custom_password': '')
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
            'id.required'              => ':attributeを入力してください。',
            'id.integer'               => ':attributeの形式が正しくありません。',
            'id.size'                  => ':attributeの形式が正しくありません。',
            'password.required'        => ':attributeを入力してください。',
            'password.string'          => ':attributeの形式が正しくありません。',
            'password.custom_password' => ':attributeの形式が正しくありません。',
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
            'id'  => '「ID」',
            'password' => '「パスワード」',
        ];
    }
}