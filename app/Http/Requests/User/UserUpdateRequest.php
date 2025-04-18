<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'firstname' => 'string',
            'lastname' => 'string',
            'username' => 'string|unique:users,username',
            'email' => 'email|unique:users,email',
            'avatar' => 'file|mimes:jpg,jpeg,png,webp,bmp,svg,ico,tiff,jfif',
        ];
    }
}
