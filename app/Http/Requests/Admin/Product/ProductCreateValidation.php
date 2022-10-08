<?php

namespace App\Http\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductCreateValidation extends FormRequest
{
    /**
     * Определяет авторизован ли пользователь, для выполнения запроса
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Правила проверки для запроса
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'description' => 'required',
            'made' => 'required',
            'price' => 'required|numeric',
            'photo_file' => 'required|max:2480|file|image'
        ];
    }
}
