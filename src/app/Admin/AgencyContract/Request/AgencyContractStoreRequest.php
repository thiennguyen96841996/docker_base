<?php
namespace App\Admin\AgencyContract\Request;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use App\Common\AgencyContract\Model\AgencyContract;

/**
 * AgencyAgencyContract情報を登録する際のバリデーションを行うクラス。
 * @package App\Admin\AgencyContract\Request
 */
class AgencyContractStoreRequest extends FormRequest
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
                $this->redirect = route('admin.agency-contract.create', ['agency_id' => $this->input('agency_id')]);
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
        return $this->only((new AgencyContract)->getFillable());
    }

    /**
     * バリデーションルールの定義を取得する。
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        $rules = [
            'start_date'        => [ 'required', 'date_format:Y-m-d', 'after:' . Carbon::now()->format('Y-m-d') ],
            'expire_in'         => [ 'required' ],
        ];
        if (!empty($this->input('end_date'))) {
            $rules['end_date'] =  ['date_format:Y-m-d', 'after:start_date'];
        }
        return $rules;
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
            //
        ];
    }

    /**
     * バリデーション要素の表示名の定義を取得する。
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return AgencyContract::getAttributeNames();
    }
}
