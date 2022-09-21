<?php
namespace GLC\Platform\Auth\Forms;

use Illuminate\Contracts\Validation\Factory as ValidationFactory;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * パスワード更新処理用のFormRequestクラス。
 *
 * @package GLC\Platform\Auth\Forms
 * @author  TinhNC <tinhhang22@gmail.com>
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
            'old_password',
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

            // 現在のパスワードをチェックする。
            /** @var \GLC\Platform\Auth\Models\AuthUser $user */
            $user = Auth::user();
            if (! Hash::check($this->input('old_password'), $user->password)) {
                $validator->errors()->add('old_password', '現在のパスワードが一致していません');
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
            'old_password' => 'required'. (is_production() ? '|password': ''),
            'password'     => 'required|confirmed'. (is_production() ? '|password': ''),
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
            'old_password.required' => ':attributeを入力してください。',
            'old_password.password' => ':attributeの形式が正しくありません。',
            'password.required'     => ':attributeを入力してください。',
            'password.password'     => ':attributeの形式が正しくありません。',
            'password.confirmed'    => ':attributeと確認入力のパスワードが一致していません。',
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
            'old_password' => '「現在のパスワード」',
            'password'     => '「新しいパスワード」',
        ];
    }
}