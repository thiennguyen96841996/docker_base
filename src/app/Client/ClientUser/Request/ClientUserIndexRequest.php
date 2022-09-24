<?php
namespace App\Client\ClientUser\Request;

use Illuminate\Contracts\Validation\Factory;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use App\Common\Database\Definition\AvailableStatus;
use App\Common\Database\Definition\DatabaseDefs;
use App\Common\ClientUser\Model\ClientUser;

/**
 * 管理ユーザー情報を検索する際のバリデーションを行うクラス。
 * @package \App\Client\ClientUser
 */
class ClientUserIndexRequest extends FormRequest
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
     * @return array<int, string>
     */
    public function validationData(): array
    {
        return $this->only([
            'id',
            'name',
            'name_kana',
            'email',
            'email',
            'tel',
            'is_available',
        ]);
    }

    /**
     * バリデーションルールの定義を取得する。
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'id'             => [ 'integer', 'exists:'.DatabaseDefs::CONNECTION_NAME_READ.'.'.ClientUser::TABLE_NAME.',id' ],
            'name'           => [ 'string', 'max:50' ],
            'name_kana'      => [ 'string', 'max:100' ],
            'email'          => [ 'string', 'max:255' ],
            'tel'            => [ 'string', 'max:15' ],
            'is_available'   => [ 'array' ],
            'is_available.*' => [ 'in:' . join(',', AvailableStatus::values()) ],
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
        return [];
    }

    /**
     * バリデーション要素の表示名の定義を取得する。
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return ClientUser::getAttributeNames();
    }
}
