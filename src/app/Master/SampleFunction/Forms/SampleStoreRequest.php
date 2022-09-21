<?php

namespace GLC\Master\SampleFunction\Forms;

use Illuminate\Foundation\Http\FormRequest;

class SampleStoreRequest extends FormRequest
{
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
        return $this->all();
    }
    /**
     * バリデーション済みのデータを取得する。
     *
     * @return array
     */
    public function getValidatedData(): array
    {
        return $this->validationData();
    }

    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required|email',
            'text' => 'required|max:10',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => ':attributeは必ず指定してください',
            'text.required' => ':attributeは必ず指定してください',
            'email.required' => ':attributeは必ず指定してください',
            'email.email' => ':attributeはメール形式で指定してください',
            'text.max' => ':attributeは:max文字以下で指定してください',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'サンプル名',
            'email' => 'eメール',
            'text' => 'サンプルテキスト',
        ];
    }
}