<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAccountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'destination' => 'nullable|regex:/^[0-9]+/|numeric|min:1|max:9999999999',
            'origin' => 'nullable|numeric|regex:/^[0-9]+/|min:1|max:9999999999',
            'amount' => 'required|numeric|regex:/^[0-9]+/|min:0|max:99999999999',
            'type' => 'required|string'


        ];
    }
    public function messages()
    {
        return [
            'destination.numeric' => 'Trường destination phải là số',
            'destination.min' => 'Trường destination phải là số lớn hơn 0',
            'destination.max' => 'Trường destination phải là số nhỏ hơn hơn 100000000000000000000',
            'destination.regex' => 'Trường destination phải gồm các số từ 0-9',
            'origin.numeric' => 'Trường origin phải là số',
            'origin.min' => 'Trường origin phải là số lớn hơn 0',
            'origin.max' => 'Trường origin phải là số nhỏ hơn hơn 100000000000000000000',
            'origin.regex' => 'Trường origin phải gồm các số từ 0-9',
            'amount.numeric' => 'Trường amount phải là số',
            'amount.required' => 'Trường amount là bắt buộc',
            'amount.min' => 'Trường amount phải là số lớn hơn hoặc bằng 0',
            'amount.max' => 'Trường amount phải là số nhỏ hơn hơn 10000000000',
            'amount.regex' => 'Trường amount phải gồm các số từ 0-9',
            'type.required' => 'Trường type là bắt buộc',
            'type.string' => 'Trường type phải là chuỗi'
        ];
    }
}
