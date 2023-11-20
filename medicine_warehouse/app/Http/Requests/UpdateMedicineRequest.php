<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMedicineRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
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
            'scientificName' => ['required','string'],
            'tradeName' => ['required','string'],
            'classification' =>['required','string'],
            'manufacturer' => ['required','string'],
            'availableQuantity' => ['required','integer'],
            'expiryDate' => ['required','date'],
            'price' => ['required','numeric'],

        ];
    }   else {
        return [
            'scientificName' => ['sometimes','required','string'],
            'tradeName' => ['sometimes','required','string'],
            'classification' =>['sometimes','required','string'],
            'CompanyNameId' => ['sometimes','required','string'],
            'availableQuantity' => ['sometimes','required','integer'],
            'expiryDate' => ['sometimes','required','date'],
            'price' => ['sometimes','required','numeric'],

        ];
    }
}
    protected function prepareForValidation() {
        $this->merge([
            'scientific_name'=> $this->scientificName ,
            'trade_name'=> $this->tradeName ,
            'expiry_date'=> $this->expiryDate , 
            'available_quantity'=> $this->availableQuantity ,
            'company_name_id'=> $this->CompanyNameId ,
            ]);
    }
        
 }

