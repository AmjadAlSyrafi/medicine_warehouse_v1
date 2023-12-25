<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatecompanyRequest extends FormRequest
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
        $method = $this->method();

        if ($method === "PUT") {
        return [
            'company_name' => ['required','string'],
            'arabic' => ['required','string'],

        ];
    }   else {
        return [
            'company_name' => ['sometimes','required','string'],
            'arabic' => ['sometimes','required','string'],
        ];
    }
    }
}
