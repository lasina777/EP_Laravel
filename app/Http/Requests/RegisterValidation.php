<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterValidation extends FormRequest
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
            'password' => 'required|min:6|confirmed',
            'email' => 'required',
            'login' => 'required|unique:users',
            'address' => 'required'
        ];
    }
}
