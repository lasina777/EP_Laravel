<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class EditUserValidation extends FormRequest
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
            'fullname' => 'required',
            'address' => 'required',
            'password' => 'nullable|min:6|confirmed'
        ];
    }
}
