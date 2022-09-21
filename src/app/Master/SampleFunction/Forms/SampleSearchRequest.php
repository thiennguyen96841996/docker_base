<?php

namespace GLC\Master\SampleFunction\Forms;

use Illuminate\Foundation\Http\FormRequest;

class SampleSearchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function validationData(): array
    {
//        return [
//            'id'   => Arr::get('id'  , ''),
//            'name' => Arr::get('name', ''),
//            'text' => Arr::get('tet' , ''),
//        ];
        return [];
    }

    /**
     * TODO、こいつ必須、ないと４０３とか返す
     * @return array
     */
    public function rules(): array
    {
        return [];
    }
    public function messages(): array
    {
        return [];
    }
    public function attributes(): array
    {
        return [];
    }

    public function validatedData(): array
    {
        return $this->all();
    }
    public function getValidatedData() :array
    {
        return $this->validatedData();
    }


}