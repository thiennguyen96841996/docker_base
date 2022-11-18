<?php
namespace App\Client\Post\Request;

use Illuminate\Contracts\Validation\Factory;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use App\Common\Post\Model\Post;

/**
 * Post情報を登録する際のバリデーションを行うクラス。
 * @package \App\Admin\AdminUser
 */
class PostStoreRequest extends FormRequest
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
        list($controller, $method) = explode('@', \Route::currentRouteAction());

        switch ($method) {
            case 'store':
            case 'createConfirm':
                $this->redirect = route('client.post.create');
                break;
            default:
                break;
        }

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
        return $this->only((new Post)->getFillable());
    }

    /**
     * バリデーションルールの定義を取得する。
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        list($controller, $method) = explode('@', \Route::currentRouteAction());
        $rule = [];

        switch ($method) {
            case 'store':
                $rule = [
                    'title'         => [ 'required', 'string', 'max:150' ],
                    'content'       => [ 'required', 'string', 'max:5000' ],
                    'city'          => [ 'required', 'string', 'max:25' ],
                    'district'      => [ 'required', 'string', 'max:20' ],
                    'status'        => [ 'required', 'string', 'max:2' ],
                    'address'       => [ 'required', 'string', 'max:100' ],
                    'price'         => [ 'required', 'integer' ],
                    'area'          => [ 'required', 'integer' ],
                ];
                break;
            case 'createConfirm':
                $rule = [
                    'title'         => [ 'required', 'string', 'max:150' ],
                    'content'       => [ 'required', 'string', 'max:5000' ],
                    'city'          => [ 'required', 'string', 'max:25' ],
                    'district'      => [ 'required', 'string', 'max:20' ],
                    'status'        => [ 'required', 'string', 'max:2' ],
                    'address'       => [ 'required', 'string', 'max:100' ],
                    'price'         => [ 'required', 'integer' ],
                    'area'          => [ 'required', 'integer' ],
                    'avatar'        => ['required', 'mimes:jpeg,png,jpg,gif', 'max: 5120']
                ];
                break;
            default:
                break;
        }
        return $rule;
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
        return Post::getAttributeNames();
    }
}
