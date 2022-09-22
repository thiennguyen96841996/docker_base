<?php
namespace GLC\Client\Auth\Forms;

use Illuminate\Foundation\Http\FormRequest;

/**
 * パスワード再発行の更新処理用のFormRequestクラス。
 *
 * @package GLC\Client\Auth\Forms
 * @author  TinhNC <tinhhang22@gmail.com>
 */
class PasswordResetRequest extends FormRequest
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
            'token',
            'email',
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
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|confirmed'. (is_production() ? '|custom_password': '')
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
            'token.required'     => ':attributeを指定してください。',
            'email.required'     => ':attributeを入力してください。',
            'email.email'        => ':attributeの形式が正しくありません。',
            'password.required'  => ':attributeを入力してください。',
            'password.password'  => ':attributeの形式が正しくありません。',
            'password.confirmed' => ':attributeと確認入力のパスワードが一致していません。',
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
            'token'    => '「トークン」',
            'email'    => '「メールアドレス」',
            'password' => '「新しいパスワード」',
        ];
    }
}