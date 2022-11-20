<?php
namespace App\Admin\Auth\Request;

use Illuminate\Contracts\Validation\Factory;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use App\Common\AdminUser\Model\AdminUser;

/**
 * ログイン情報が正しいかどうかのバリデーションを行うクラス。
 * @package \App\Admin\Auth
 */
class LoginRequest extends FormRequest
{
    /**
     * リクエストが可能かどうかを返す。
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * バリデーターを作成して返す。
     * @param  \Illuminate\Contracts\Validation\Factory $factory
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(Factory $factory): Validator
    {
        $validator = $factory->make(
            $this->validationData(),
            $this->container->call([$this, 'rules']),
            $this->messages(),
            $this->attributes()
        )->stopOnFirstFailure($this->stopOnFirstFailure);

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
     * バリデーション対象となるデータを取得する。
     * @return array
     */
    public function validationData(): array
    {
        return $this->only([
            'email',
            'password',
        ]);
    }

    /**
     * バリデーションルールの定義を取得する。
     * @return array
     */
    public function rules(): array
    {
        return [
            'email'    => [ 'required', 'email' ],
            'password' => [ 'required', App::isProduction() ? Password::default(): 'string' ],
        ];
    }

    /**
     * バリデーションエラー時に返却するメッセージの定義を取得する。
     * @return array
     */
    public function messages(): array
    {
        // メッセージはlang下のファイルで管理する。
        // 上書きしたいメッセージがある場合にのみ設定すること。
        return [
            'email.required'    => ':attribute không được trống.',
            'email.email'       => ':attribute không đúng định dạng.',
            'password.required' => ':attribute không được trống.'
        ];
    }

    /**
     * バリデーション要素の表示名の定義を取得する。
     * @return array
     */
    public function attributes(): array
    {
        return AdminUser::getAttributeNames();
    }

    /**
     * 認証する。
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate()
    {
        $this->ensureIsNotRateLimited();

        if (!Auth::attempt($this->validationData())) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ])->status(401);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * レートリミットの判定を行う。
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ])->status(401);
    }

    /**
     * レートリミットに使用するキーを取得する。
     * @return string
     */
    public function throttleKey(): string
    {
        return Str::lower($this->input('email')).'|'.$this->ip();
    }
}
