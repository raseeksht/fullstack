<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\BaseRequest as BaseRequest;

class UserRequest extends BaseRequest
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
        if ($this->isMethod('post'))
        {
            // Rules for creating a user
            return [
                'name' => 'required|string|max:255|min:5',
                'email' => 'required|email',
                'password' => 'required|min:8',
            ];
        }

        if ($this->isMethod('patch'))
        {
            // Rules for updating a user
            return [
                'name' => 'required|string|max:255|min:5',
                'email' => 'required|email',
            ];
        }
    }
}
