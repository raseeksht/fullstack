<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends BaseRequest
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
                'commentContent' => ['required'],
                'parent' => ['sometimes', 'int'],
                'blog_id' => ['required', 'int'],
            ];
        } elseif ($this->isMethod('delete'))
        {
            // dd(request()->all());
            return [
                'blog_id' => ['required', 'int'],
            ];
        } elseif ($this->isMethod('patch'))
        {
            return [
                'commentContent' => ['required'],
            ];
        }

    }
}
