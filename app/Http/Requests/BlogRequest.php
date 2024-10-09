<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogRequest extends BaseRequest
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
        if ($this->isMethod("post"))
        {
            return [
                'title' => ['required', 'min:10'],
                'content' => ['required', 'min:40'],
                'image' => 'nullable|image|mimes:jpg,png,jpeg,webp,gif'
            ];
        } elseif ($this->isMethod('patch'))
        {
            return [
                'title' => ['required', 'min:10'],
                'content' => ['required', 'min:40'],
                // 'image' => 'nullable|image|mimes:jpg,png,jpeg,webp,gif'

            ];
        }
    }
}
