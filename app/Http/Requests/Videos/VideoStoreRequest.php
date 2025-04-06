<?php

namespace App\Http\Requests\Videos;

use Illuminate\Foundation\Http\FormRequest;

class VideoStoreRequest extends FormRequest
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
            'title' => 'required|string',
            'description' => 'string',
            'thumbnail' => 'required|file|mimes:jpg,jpeg,png',
            'video' => 'required|file|mimes:mp4,ogg,ogv,webm,mpeg,mp3,mkv,mov',
        ];
    }
}
