<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMedicine_orderRequest extends FormRequest
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
                'payment_status' => ['required','string'],
                'total_price' =>['required','integer'],
            ];
        }   else {
            return [
                'payment_status' => ['sometimes','required','string'],
                'total_price'=> ['sometimes','required','integer'],
            ];
        }
    }
}
