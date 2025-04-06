<?php

namespace App\Http\Requests\Stories;

use Illuminate\Foundation\Http\FormRequest;

class StoryStoreRequest extends FormRequest
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
            'description' => 'string',
            'thumbnail' => 'required|file|mimes:jpg,jpeg,png',
            'story' => 'required|file|mimes:mp4,ogg,ogv,webm,mpeg,mp3,mkv,mov|max:20480',
        ];
    }
}
