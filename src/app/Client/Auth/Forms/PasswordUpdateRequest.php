<?php
namespace GLC\Client\Auth\Forms;

use Illuminate\Contracts\Validation\Factory as ValidationFactory;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

/**
 * パスワード更新処理用のFormRequestクラス。
 *
 * @package GLC\Client\Auth\Forms
 */
class PasswordUpdateRequest extends FormRequest
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
            'password',
            'password_confirmation',
        ]);
    }

    /**
     * バリデーターを作成して返す。
     *
     * @param  \Illuminate\Contracts\Validation\Factory $factory Factoryオブジェクト
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(ValidationFactory $factory): Validator
    {
        $validator = $factory->make(
            $this->validationData(), $this->container->call([$this, 'rules']),
            $this->messages(), $this->attributes()
        );

        // 追加の特殊バリデーションを設定する。
        $validator->after(function($validator) {
            /** @var \Illuminate\Validation\Validator $validator */
            // すでにエラーがある場合は確認しない。
            if ($validator->errors()->isNotEmpty()) {
                return;
            }
        });
        return $validator;
    }

    /**
     * バリデーションルールの配列を取得する。
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'password'     => 'required|confirmed'. (is_production() ? '|custom_password': ''),
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
            'password.required'        => ':attributeを入力してください。',
            'password.password'        => ':attributeの形式が正しくありません。',
            'password.custom_password' => ':attributeの形式が正しくありません。',
            'password.confirmed'       => 'パスワードが一致しません。',
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
            'password'     => '「新しいパスワード」',
        ];
    }
}